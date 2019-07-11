<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Models\NoaaPrediction;
use App\Models\NoaaStation;
use App\Models\WeatherData;
use App\Models\WeatherForecast;

class GetPredictions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:predictions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape data from Stormglass for NOAA wave predictions.';

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
        $stations = NoaaStation::where('active', true)->get();
        
        $bar = $this->output->createProgressBar(count($stations));

        foreach ($stations as $station) {

            $this->info("\nScraping swell info for {$station->title}.");

            $lat = $station->lat;
            $lng = $station->lng;
            
            try {
                $url = config('apis.stormglass.url');
                $params = [
                    'lat' => $lat,
                    'lng' => $lng,
                    'params' => 'swellDirection,swellHeight,swellPeriod,waterTemperature,waveDirection,waveHeight,wavePeriod,windDirection,windSpeed',
                    'source' => 'noaa',
                ];
                $headers = ['Authentication-Token' => config('apis.stormglass.apiKey')];

                $client = new \GuzzleHttp\Client();
                $res = $client->request('GET', $url, [
                    'headers' => $headers,
                    'query' => $params
                ]);
            } catch(\Exception $e) {
                $this->error($e->getMessage());
                return;
            } 

            $contents = json_decode($res->getBody());
            
            foreach ($contents->hours as $item) {

                $now = new Carbon();
                $sevenDays = $now->addDays(7);

                $itemTime = Carbon::parse($item->time);

                if ($itemTime > $sevenDays) {
                    break;
                }

                $wavePeriod = isset($item->wavePeriod[0]->value) ? $item->wavePeriod[0]->value : null;
                $windDirection = isset($item->windDirection[0]->value) ? $item->windDirection[0]->value : null;

                $windSpeed = isset($item->windSpeed[0]->value) ? $item->windSpeed[0]->value * 2.23694 : null;
                $swellHeight = isset($item->swellHeight[0]->value) ? $item->swellHeight[0]->value * 3.28084 : null;
                $waveHeight = isset($item->waveHeight[0]->value) ? $item->waveHeight[0]->value * 3.28084 : null;

                try {
                    if ($record = NoaaPrediction::where('timestamp', $itemTime)->where('noaa_station_id', $station->id)->first()) {
                        $record->swell_direction = $item->swellDirection[0]->value;
                        $record->swell_height = $swellHeight;
                        $record->swell_period = $item->swellPeriod[0]->value;
                        $record->wave_direction = $item->waveDirection[0]->value;
                        $record->wave_height = $waveHeight;
                        $record->wave_period = $wavePeriod;
                        $record->wind_direction = $windDirection;
                        $record->wind_speed = $windSpeed;
                        $record->save();
                    } else {
                        $record = NoaaPrediction::create([
                            'noaa_station_id' => $station->id,
                            'timestamp' => $itemTime,
                            'swell_direction' => $item->swellDirection[0]->value,
                            'swell_height' => $swellHeight,
                            'swell_period' => $item->swellPeriod[0]->value,
                            'wave_direction' => $item->waveDirection[0]->value,
                            'wave_height' => $waveHeight,
                            'wave_period' => $wavePeriod,
                            'wind_direction' => $windDirection,
                            'wind_speed' => $windSpeed,
                        ]);
                    }
                } catch(\Exception $e) {

                    $this->error($e->getMessage());
                    continue;
                }

                // $record = NoaaPrediction::updateOrCreate(
                //     [
                //         'timestamp' => $itemTime,
                //         'noaa_station_id' => $station->id,
                //     ],
                //     [
                //         'noaa_station_id' => $station->id,
                //         'timestamp' => $itemTime,
                //         'swell_direction' => $item->swellDirection[0]->value,
                //         'swell_height' => $swellHeight,
                //         'swell_period' => $item->swellPeriod[0]->value,
                //         'wave_direction' => $item->waveDirection[0]->value,
                //         'wave_height' => $waveHeight,
                //         'wave_period' => $wavePeriod,
                //         'wind_direction' => $windDirection,
                //         'wind_speed' => $windSpeed,
                //     ]
                // );
            }

            $requestCount = $contents->meta->requestCount;

            $bar->advance();
        }

        $bar->finish();

        $this->info("\nScraped and stored swell data for each station.\n");

        $this->info("{$requestCount} requests made to Stormglass.");

        return;
    }
}
