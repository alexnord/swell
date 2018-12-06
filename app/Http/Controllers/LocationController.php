<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\LocationService;
use App\Services\TideService;
use App\Services\BuoyService;
use App\Services\WeatherService;

class LocationController extends Controller
{
    private $locationService;
    private $tideService;
    private $buoyService;
    private $weatherService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        LocationService $locationService,
        TideService $tideService,
        BuoyService $buoyService,
        WeatherService $weatherService
    )
    {
        $this->locationService = $locationService;
        $this->tideService = $tideService;
        $this->buoyService = $buoyService;
        $this->weatherService = $weatherService;
    }

    /**
     * Show the location view.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($location)
    {
        $location = $this->locationService->getLocationBySlug($location);
        $tz = $location->timezone;

        $buoyData    = $this->buoyService->getLatestBuoyData($location->buoy, 10, $tz);
        $tideData    = $this->tideService->getLatestTide($location->station, $tz);
        $weatherData = $this->weatherService->getWeatherData($location, 10, $tz);

        $tides = [];

        $now = Carbon::now($tz);
        $todayMidnight = $now->startOfDay();
        $hourlyBreakdowns = $this->locationService->getHourlyBreakdownsForWeek($todayMidnight, $tz, $location->station->id);

        $data = [
            'location' => $location->title,
            'buoy' => $buoyData,
            'weather' => $weatherData,
            'tide' => $tideData,
            'tides' => $tides,
            'predictions' => $hourlyBreakdowns,
        ];

        return view('location')->with([
            'data' => json_encode($data),
        ]);
    }
}
