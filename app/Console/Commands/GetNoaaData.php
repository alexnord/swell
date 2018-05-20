<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Noaa;
use App\Location;

class GetNoaaData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:scrape';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape data from external sources.';

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

            $this->info("Scraping swell info for {$location->title}.");

            $lat = $location->lat;
            $long = $location->long;
            
            // $url = config('apis.stormglass.url') . '?lat=' . $lat . '&lng=' . $long;
            // $headers = ['Authentication-Token' => config('apis.stormglass.apiKey')];
            // $client = new \GuzzleHttp\Client();
            // $res = $client->request('GET', $url, [
            //     'headers' => $headers
            // ]);

            // if ($res->getStatusCode() !== '200') {
            // } else {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Could not retrieve Stormglass data.',
            //     ]);
            // }

            // $contents = json_decode($res->getBody());
            $contents = json_decode(Storage::get('public/rincon.json'));
            
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
                    if ($record = Noaa::where('timestamp', $itemTime)->where('location_id', $location->id)->first()) {
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
                        $record = Noaa::create([
                            'location_id' => $location->id,
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

        $this->info('Scraped and stored swell data for each location.');
        return;
    }
}
