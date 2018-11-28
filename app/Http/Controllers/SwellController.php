<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use Carbon\Carbon;
use App\Location;
use App\BuoyData;
use App\TideData;
use App\WeatherData;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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
            return response()->json([
                'success' => false,
                'data' => [
                    'location_id' => $locationId,
                    'date' => $date,
                    'start_time' => $startTime,
                    'end_time' => $endTime,
                ],
            ], 400);
        }

        $userTz = Auth::user()->timezone;

        $formattedDate = Carbon::parse($date);
        $formattedStartTime = Carbon::parse($date.' '.$startTime, $userTz)->setTimezone('UTC');
        $formattedEndTime = Carbon::parse($date.' '.$endTime, $userTz)->setTimezone('UTC');

        $location = Location::find($locationId);

        // Get tide data
        try {
            $tides = $this->getTides(
                $formattedDate,
                $formattedStartTime,
                $formattedEndTime,
                $location->noaa_station_id
            );
        } catch(\Exception $e) {
            $tides = [];
        } 

        // Get buoy data
        try {
            $buoys = $this->getBuoyData($formattedStartTime, $formattedEndTime, $location->buoy_id);
        } catch(\Exception $e) {
            $buoys = [];
        } 

        try {
            $wind = $this->getWind($formattedStartTime, $formattedEndTime, $location->id);
        } catch(\Exception $e) {
            $wind = [];
        } 

        return response()->json([
            'success' => true,
            'data' => [
                'tides' => $tides,
                'buoys' => $buoys,
                'wind' => $wind,
            ],
        ]);
    }

    private function getTides($formattedDate, $formattedStartTime, $formattedEndTime, $stationId)
    {
        $tideBeforeStart = TideData::select('height', 'timestamp')
                            ->where('timestamp', '<=', $formattedStartTime)
                            ->where('noaa_station_id', $stationId)
                            ->orderBy('timestamp', 'desc')
                            ->first()->toArray();
        $tideAfterStart = TideData::select('height', 'timestamp')
                            ->where('timestamp', '>=', $formattedStartTime)
                            ->where('noaa_station_id', $stationId)
                            ->orderBy('timestamp', 'asc')
                            ->first()->toArray();
        $tideBeforeEnd = TideData::select('height', 'timestamp')
                            ->where('timestamp', '<=', $formattedEndTime)
                            ->where('noaa_station_id', $stationId)
                            ->orderBy('timestamp', 'desc')
                            ->first()->toArray();
        $tideAfterEnd = TideData::select('height', 'timestamp')
                            ->where('timestamp', '>=', $formattedEndTime)
                            ->where('noaa_station_id', $stationId)
                            ->orderBy('timestamp', 'asc')
                            ->first()->toArray();

        // Calculate start tide
        $startDiff = Carbon::parse($tideBeforeStart['timestamp'])->diffInMinutes(Carbon::parse($tideAfterStart['timestamp']));
        $startChange = abs($tideBeforeStart['height'] - $tideAfterStart['height']);
        $startFtPerMin = $startChange / $startDiff;
        $startTideStartTimeDiff = $formattedStartTime->diffInMinutes(Carbon::parse($tideBeforeStart['timestamp']));
        $tidediffStart = $startTideStartTimeDiff * $startFtPerMin;
        
        $tideAtStart = ($tideBeforeStart > $tideAfterStart) ? 
            $tideBeforeStart['height'] - $tidediffStart : 
            $tideBeforeStart['height'] + $tidediffStart;

        // Calculate end tide
        $endDiff = Carbon::parse($tideBeforeEnd['timestamp'])->diffInMinutes(Carbon::parse($tideAfterEnd['timestamp']));
        $endChange = abs($tideBeforeEnd['height'] - $tideAfterEnd['height']);
        $endFtPerMin = $endChange / $endDiff;

        $endTideEndTimeDiff = $formattedEndTime->diffInMinutes(Carbon::parse($tideBeforeEnd['timestamp']));
        $tidediffEnd = $endTideEndTimeDiff * $endFtPerMin;

        $tideAtEnd = ($tideBeforeEnd > $tideAfterEnd) ? 
            $tideBeforeEnd['height'] - $tidediffEnd : 
            $tideBeforeEnd['height'] + $tidediffEnd;

        $dir = ($tideAtStart > $tideAtEnd) ? 
            'Dropping' : 'Rising';

        return [
            'tideAtStart' => round($tideAtStart, 1),
            'tideAtEnd' => round($tideAtEnd, 1),
            'median' => round((round($tideAtStart, 1)+round($tideAtEnd, 1))/2, 2),
            'dir' => $dir,
        ];
    }

    private function getBuoyData($startTime, $endTime, $buoyId)
    {
        $buoyData = BuoyData::select('timestamp', 'wave_height', 'dominant_period', 'angle')
            ->where('timestamp', '>=', $startTime)
            ->where('timestamp', '<=', $endTime)
            ->where('buoy_id', $buoyId)
            ->orderBy('timestamp', 'asc')
            ->get()->toArray();

        $buoyCount = count($buoyData);

        foreach ($buoyData as $key => $buoy) {
            $buoyData[$key]['direction'] = Helper::getDirection($buoy['angle']);
            $buoyData[$key]['wave_height'] = round($buoyData[$key]['wave_height'], 2);
        }

        $avg = [
            'wave_height' => round(($buoyData[0]['wave_height'] + $buoyData[$buoyCount-1]['wave_height'])/2, 2),
            'period' => ($buoyData[0]['dominant_period'] + $buoyData[$buoyCount-1]['dominant_period'])/2,
            'angle' => ($buoyData[0]['angle'] + $buoyData[$buoyCount-1]['angle'])/2,
            'direction' => Helper::getDirection(($buoyData[0]['angle'] + $buoyData[$buoyCount-1]['angle'])/2)
        ];

        return [
            'startBuoy' => $buoyData[0],
            'endBuoy' => $buoyData[$buoyCount-1],
            'average' => $avg,
        ];
    }

    private function getWind($startTime, $endTime, $locationId)
    {
        $windData = WeatherData::select('timestamp', 'angle', 'speed')
            ->where('timestamp', '>=', $startTime)
            ->where('timestamp', '<=', $endTime)
            ->where('location_id', $locationId)
            ->orderBy('timestamp', 'asc')
            ->get()->toArray();

        $windCount = count($windData);

        foreach ($windData as $key => $value) {
            $windData[$key]['direction'] = Helper::getDirection($value['angle']);
        }

        $avg = [
            'angle' => ($windData[0]['angle'] + $windData[$windCount-1]['angle'])/2,
            'direction' => Helper::getDirection(($windData[0]['angle'] + $windData[$windCount-1]['angle'])/2),
            'speed' => ($windData[0]['speed'] + $windData[$windCount-1]['speed'])/2,
        ];

        return [
            'startWind' => $windData[0],
            'endWind' => $windData[count($windData)-1],
            'average' => $avg,
        ];

        return $windData;
    }

}
