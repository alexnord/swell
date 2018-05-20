<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Noaa;

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
        // $lat = '34.0012040';
        // $long = '-118.8068260';
        // $url = config('apis.stormglass.url') . '?lat=' . $lat . '&lng=' . $long;
        // $headers = ['Authentication-Token' => config('apis.stormglass.apiKey')];
        // $client = new \GuzzleHttp\Client();
        // $res = $client->request('GET', $url, [
        //     'headers' => $headers
        // ]);

        // echo $res->getBody();
        // exit;

        // if ($res->getStatusCode() === '200') {
        // } else {
        //     echo 'an error occurred.';
        // }

        $contents = json_decode(Storage::get('public/rincon.json'));
        
        foreach ($contents->hours as $item) {

            $now = new Carbon();
            dd($now);

            $dt = Carbon::parse($item->time);

            $wavePeriod = isset($item->wavePeriod[1]->value) ? $item->wavePeriod[1]->value : null;
            $windDirection = isset($item->windDirection[1]->value) ? $item->windDirection[1]->value : null;

            $windSpeed = isset($item->windSpeed[1]->value) ? $item->windSpeed[1]->value * 2.23694 : null;
            $swellHeight = $item->swellHeight[1]->value * 3.28084;
            $waveHeight = $item->waveHeight[1]->value * 3.28084;

            try {
                $record = Noaa::create([
                    'timestamp' => $dt,
                    'swell_direction' => $item->swellDirection[1]->value,
                    'swell_height' => $swellHeight,
                    'swell_period' => $item->swellPeriod[1]->value,
                    'wave_direction' => $item->waveDirection[1]->value,
                    'wave_height' => $waveHeight,
                    'wave_period' => $wavePeriod,
                    'wind_direction' => $windDirection,
                    'wind_speed' => $windSpeed,
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                // If there's an integrity constraint violation
                continue;
            }

            return response()->json([
                'success' => true,
                'data' => $record,
            ]);
        }
    }
}
