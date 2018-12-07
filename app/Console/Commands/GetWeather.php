<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\Location;
use App\Models\WeatherData;
use App\Models\WeatherForecast;

class GetWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:weather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get weather data via an external API.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $locations = Location::where('active', true)->get();

        $bar = $this->output->createProgressBar(count($locations));

        foreach ($locations as $location) {

            $this->info("\n");
            $this->info("Scraping wind data for {$location->title}.");

            $this->getDarkSkyWeather($location);

            $bar->advance();
        }

        $bar->finish();
        $this->info("\n");
        $this->info("Scraped and stored wind data for each location.");
    }

    /**
     * Get and store DarkSky weather data.
     *
     * @param Location $location
     * @return mixed
     */
    private function getDarkSkyWeather(Location $location) {
        $baseUrl = config('apis.weather.darksky.url');
        $apiKey = config('apis.weather.darksky.apiKey');

        $uri = $baseUrl . "/forecast/$apiKey/$location->lat,$location->lng?exclude=minutely,alerts,flags";
        
        try {
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', $uri, []);
        } catch(\Exception $e) {
            $this->error($e->getMessage());
            return;
        }

        $contents = json_decode($res->getBody());

        // Storage::put('weather.json', $res->getBody());
        // $contents = json_decode(Storage::get('weather.json'));

        $timestamp = Carbon::createFromTimestamp($contents->currently->time);
        $dir = $contents->currently->windBearing;
        $speed = $contents->currently->windSpeed;
        $temp = $contents->currently->temperature;
        $text = $contents->currently->summary;
        $sunrise = Carbon::createFromTimestamp($contents->daily->data[0]->sunriseTime)->setTimezone($location->timezone)->format('g:i A');
        $sunset = Carbon::createFromTimestamp($contents->daily->data[0]->sunsetTime)->setTimezone($location->timezone)->format('g:i A');

        $data = [
            'timestamp' => $timestamp,
            'location_id' => $location->id,
            'angle' => $dir,
            'speed' => $speed,
            'temp' => $temp,
            'text' => $text,
            'sunrise' => $sunrise,
            'sunset' => $sunset,
        ];

        $record = WeatherData::updateOrCreate($data);

        $forecasts = $this->updateForecast($location, $contents);

        return;
    }

    /**
     * Update weather forecasts.
     *
     * @param Location $location
     * @param mixed $contents
     * @return mixed
     */
    private function updateForecast(Location $location, $contents)
    {
        foreach ($contents->hourly->data as $hour) {
            $data = [
                'timestamp' => Carbon::createFromTimestamp($hour->time),
                'location_id' => $location->id,
                'text' => $hour->summary,
                'icon' => $hour->icon,
                'temperature' => $hour->temperature,
                'angle' => $hour->windBearing,
                'speed' => $hour->windSpeed,
            ];

            $record = WeatherForecast::updateOrCreate($data);
        }

        return;
    }

    /**
     * Get and store Yahoo! weather data.
     *
     * @param Location $location
     * @return mixed
     */
    private function getYahooWeather(Location $location) {
        $baseUrl = config('apis.weather.yahoo');
        $yqlQuery = 'select wind, item.condition, astronomy from weather.forecast where woeid in (select woeid from geo.places(1) where text="('.$location->lat.', '.$location->lng.')")';
        $yqlQueryUrl = $baseUrl . "?q=" . urlencode($yqlQuery) . "&format=json";
        
        try {
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', $yqlQueryUrl, []);
        } catch(\Exception $e) {
            $this->error($e->getMessage());
            return;
        }

        $contents = json_decode($res->getBody());

        // dd($contents);

        $timestamp = Carbon::parse($contents->query->created);
        $dir = $contents->query->results->channel->wind->direction;
        $speed = $contents->query->results->channel->wind->speed;
        $temp = $contents->query->results->channel->item->condition->temp;
        $text = $contents->query->results->channel->item->condition->text;
        $sunrise = $contents->query->results->channel->astronomy->sunrise;
        $sunset = $contents->query->results->channel->astronomy->sunset;

        // Skip duplicates
        if ($record = WeatherData::where('timestamp', $timestamp)->where('location_id', $location->id)->first()) {
            return;
        }

        try {
            $record = WeatherData::create([
                'timestamp' => $timestamp,
                'location_id' => $location->id,
                'angle' => $dir,
                'speed' => $speed,
                'temp' => $temp,
                'text' => $text,
                'sunrise' => $sunrise,
                'sunset' => $sunset,
            ]);
        } catch(\Exception $e) {
            $this->error($e->getMessage());
            return;
        }

        return;
    }
}
