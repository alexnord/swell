<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Location;
use App\WeatherData;

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
    protected $description = 'Get weather via Yahoo! API.';

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
            $this->info("Scraping wind data for {$location->title}.");

            $baseUrl = config('apis.weather');
            $yqlQuery = 'select wind from weather.forecast where woeid in (select woeid from geo.places(1) where text="('.$location->lat.', '.$location->lng.')")';
            $yqlQueryUrl = $baseUrl . "?q=" . urlencode($yqlQuery) . "&format=json";
            
            try {
                $client = new \GuzzleHttp\Client();
                $res = $client->request('GET', $yqlQueryUrl, []);
            } catch(\Exception $e) {
                $this->error($e->getMessage());
                return;
            }

            $contents = json_decode($res->getBody());

            $timestamp = Carbon::parse($contents->query->created);
            $dir = $contents->query->results->channel->wind->direction;
            $speed = $contents->query->results->channel->wind->speed;

            // Skip duplicates
            if ($record = WeatherData::where('timestamp', $timestamp)->where('location_id', $location->id)->first()) {
                continue;
            }

            try {
                $record = WeatherData::create([
                    'timestamp' => $timestamp,
                    'location_id' => $location->id,
                    'direction' => $dir,
                    'speed' => $speed,
                ]);
            } catch(\Exception $e) {
                $this->error($e->getMessage());
                continue;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->info("\nScraped and stored wind data for each location.\n");
    }
}
