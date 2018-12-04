<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use Carbon\Carbon;
use App\Models\BuoyData;
use App\Models\TideData;
use App\Models\WeatherData;
use App\Services\TideService;

class HomeController extends Controller
{
    private $tideService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TideService $tideService)
    {
        $this->middleware('auth');
        $this->tideService = $tideService;
    }

    /**
     * Show the create entry form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tz = Auth::user()->timezone;
        $stationId = 1;

        $buoy    = $this->getBuoyData();
        $weather = $this->getWeatherData($tz);
        // Get the high and lows for a given week
        $days = [];
        for ($i=0; $i < 7 ; $i++) { 
            $days[] = Carbon::now($tz)->startOfDay()->addDays($i);
        }
        $tides = $this->tideService->getTidesForWeek($days, $tz, $stationId);

        $data = [
            'buoy' => $buoy,
            'weather' => $weather,
            'tides' => $tides,
        ];

        return view('home')->with([
            'data' => json_encode($data),
        ]);
    }

    private function getBuoyData()
    {
        $buoy = BuoyData::whereHas('buoy', function ($query) {
                $query->where('id', '=', 1);
            })
            ->orderBy('timestamp', 'desc')
            ->first();

        return $buoy->toArray();
    }

    private function getWeatherData($tz)
    {
        $data = WeatherData::whereHas('location', function ($query) {
                $query->where('id', '=', 7);
            })
            ->orderBy('timestamp', 'desc')
            ->first();

        return $data->toArray();
    }
}
