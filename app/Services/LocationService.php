<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Location;
use App\Services\TideService;
use App\Services\PredictionService;

class LocationService
{
    private $tideService;
    private $predictionService;

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct(
        TideService $tideService,
        PredictionService $predictionService
    )
    {
        $this->tideService = $tideService;
        $this->predictionService = $predictionService;
    }

    /**
     * Get a location by slug.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLocationBySlug($slug)
    {
        if (!$location = Location::where('slug', $slug)
                ->with('buoy')->with('station')->first()) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException;
        }

        return $location;
    }

    /**
     * Get the hourly breakdown of tide data for a given week.
     *
     * @param Carbon $dayMidnight
     * @param string $tz
     * @param string $stationId
     * @return array
     */
    public function getHourlyBreakdownsForWeek(Carbon $dayMidnight, $tz, $stationId) : array
    {
        $data = [];
        for ($i=0; $i < 7 ; $i++) {

            $hours = $this->getHours($dayMidnight, $tz, $stationId);

            $hourData = [];
            foreach ($hours as $hour) {
                $hourlyData['time_utc'] = $hour->copy()->format('g:i A');
                $hourlyData['time_local'] = $hour->copy()->setTimezone($tz)->format('g:i A');

                $tideHeight = $this->tideService->getHeightAtHour($hour, $tz, $stationId);
                $hourlyData['tide'] = $tideHeight;

                $swell = $this->predictionService->getBuoyAtHour($hour, $tz, $stationId);
                $hourlyData['swell'] = $swell;
                
                $wind = $this->predictionService->getWindAtHour($hour, $tz, $stationId);
                $hourlyData['wind'] = $wind;

                $hourData[] = $hourlyData;
            }

            // Add the direction of the tide to the array values
            foreach ($hourData as $index => $datum) {
                $direction = '';
                if(isset($hourData[$index+1]['tide']['height'])) {
                    $direction = $hourData[$index]['tide']['height'] < $hourData[$index+1]['tide']['height'] ?
                        'rising' : 'falling';
                }
                $hourData[$index]['tide']['direction'] = $direction;
            }

            $data[] = [
                'date' => $dayMidnight->copy()->addDays($i)->toDayDateTimeString(),
                'data' => $hourData
            ];
        }

        return $data;
    }

    /**
     * Get an array of hours from a given day.
     *
     * @param Carbon $dayMidnight
     * @param string $tz
     * @param string $stationId
     * @return array
     */
    public function getHours(Carbon $dayMidnight, $tz, $stationId) : array
    {
        $start = $dayMidnight->copy()->setTimezone('UTC');

        $hours = [];
        for ($i=0; $i <24 ; $i++) { 
            $hour = $start->copy()->addHours($i);
            $hours[] = $hour;
        }

        return $hours;
    }
}
