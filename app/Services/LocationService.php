<?php

namespace App\Services;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use Carbon\Carbon;
use App\Models\BuoyData;
use App\Models\TideData;
use App\Models\WeatherData;
use App\Models\Location;

class LocationService
{
    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the location view.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLocationBySlug($slug)
    {
        if (!$location = Location::where('slug', '=', $slug)->first()) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }

        

        return view('location')->with([
            'data' => json_encode([]),
        ]);
    }
}
