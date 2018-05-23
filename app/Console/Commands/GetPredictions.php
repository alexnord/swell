<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\NoaaPrediction;
use App\NoaaStation;

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
                $url = config('apis.stormglass.url') . '?lat=' . $lat . '&lng=' . $lng;
                $headers = ['Authentication-Token' => config('apis.stormglass.apiKey')];
                $client = new \GuzzleHttp\Client();
                $res = $client->request('GET', $url, [
                    'headers' => $headers
                ]);
            } catch(\Exception $e) {
                $this->error($e->getMessage());
                return;
            } 

            $contents = json_decode($res->getBody());
            // $contents = json_decode(Storage::get('public/rincon.json'));
            
            foreach ($contents->hours as $item) {

                $now = new Carbon();
                $tomorrow = $now->addDay();

                $itemTime = Carbon::parse($item->time);

                if ($itemTime > $tomorrow) {
                    break;
                }

                $wavePeriod = isset($item->wavePeriod[1]->value) ? $item->wavePeriod[1]->value : null;
                $windDirection = isset($item->windDirection[1]->value) ? $item->windDirection[1]->value : null;

                $windSpeed = isset($item->windSpeed[1]->value) ? $item->windSpeed[1]->value * 2.23694 : null;
                $swellHeight = $item->swellHeight[1]->value * 3.28084;
                $waveHeight = $item->waveHeight[1]->value * 3.28084;

                try {
                    if ($record = NoaaPrediction::where('timestamp', $itemTime)->where('noaa_station_id', $station->id)->first()) {
                        $record->swell_direction = $item->swellDirection[1]->value;
                        $record->swell_height = $swellHeight;
                        $record->swell_period = $item->swellPeriod[1]->value;
                        $record->wave_direction = $item->waveDirection[1]->value;
                        $record->wave_height = $waveHeight;
                        $record->wave_period = $wavePeriod;
                        $record->wind_direction = $windDirection;
                        $record->wind_speed = $windSpeed;
                        $record->save();
                    } else {
                        $record = NoaaPrediction::create([
                            'noaa_station_id' => $station->id,
                            'timestamp' => $itemTime,
                            'swell_direction' => $item->swellDirection[1]->value,
                            'swell_height' => $swellHeight,
                            'swell_period' => $item->swellPeriod[1]->value,
                            'wave_direction' => $item->waveDirection[1]->value,
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
