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
use App\Services\LocationService;

class LocationController extends Controller
{
    private $locationService;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
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

        dd($location);

        return view('location')->with([
            'data' => json_encode([]),
        ]);
    }
}
