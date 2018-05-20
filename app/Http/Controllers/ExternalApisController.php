<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Noaa;
use App\Location;

class ExternalApisController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Do something.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $locations = Location::where('active', true)->get();
        
        foreach ($locations as $location) {
            $lat = $location->lat;
            $long = $location->long;
            
            $url = config('apis.stormglass.url') . '?lat=' . $lat . '&lng=' . $long;
            $headers = ['Authentication-Token' => config('apis.stormglass.apiKey')];
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', $url, [
                'headers' => $headers
            ]);

            if ($res->getStatusCode() !== '200') {
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Could not retrieve Stormglass data.',
                ]);
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
                    return $e->getMessage();
                }
            }

            $requestCount = $contents->meta->requestCount;
        }


        return response()->json([
            'success' => true,
            'message' => 'Succesfully parsed and stored data.',
            'data' => [
                'requestCount' => $requestCount,
            ],
        ]);
    }
}
