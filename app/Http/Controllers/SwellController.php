<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Location;
use App\TideData;
use App\BuoyData;

class SwellController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSwellData(Request $request)
    {
        $locationId = $request->input('location_id') ?: null;
        $date = $request->input('date') ?: null;
        $startTime = $request->input('start_time') ?: null;
        $endTime = $request->input('end_time') ?: null;

        if (!$locationId || !$date || !$startTime || !$endTime) {
            throw new BadRequestHttpException('Missing GET variables.');
        }

        $formattedStartTime = Carbon::parse($date.' '.$startTime);
        $formattedEndTime = Carbon::parse($date.' '.$endTime);

        $location = Location::find($locationId);
        $noaaStation = $location->station;

        dd($location->buoy_id);exit;

        $buoyData = BuoyData::where('timestamp', '>=', $formattedStartTime)
            ->where('timestamp', '<=', $formattedEndTime)
            ->where('buoy_id', $location->buoy_id)
            ->get();
        dd($buoyData);

        return;
    }

}
