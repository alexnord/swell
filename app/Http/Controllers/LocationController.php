<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Services\LocationService;
use App\Services\TideService;

class LocationController extends Controller
{
    private $locationService;
    private $tideService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        LocationService $locationService,
        TideService $tideService
    )
    {
        $this->locationService = $locationService;
        $this->tideService = $tideService;
        $this->middleware('auth');
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
        $stationId = $location->station->id;

        $now = Carbon::now($tz);
        $todayMidnight = $now->startOfDay();

        $days = [];
        for ($i=0; $i < 7 ; $i++) { 
            $days[] = Carbon::now($tz)->startOfDay()->addDays($i);
        }

        $weeklyTides = $this->tideService->getTidesForWeek($days, $tz, $stationId);

        dd($weeklyTides);

        return view('location')->with([
            'data' => json_encode([]),
        ]);
    }
}
