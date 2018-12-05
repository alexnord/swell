<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\NoaaPrediction;
use App\Services\TideService;
use App\Helpers\Helper;

class PredictionService
{
    private $tideService;

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct(TideService $tideService)
    {
        $this->tideService = $tideService;
    }

    /**
     * Get the predicted swell data at a given hour.
     *
     * @param Carbon $hour
     * @param string $tz
     * @param string $stationId
     * @return array
     */
    public function getBuoyAtHour(Carbon $hour, $tz, $stationId) : array
    {
        $selectFields = [
            'swell_direction', 
            'swell_height', 
            'swell_period', 
            'wave_height', 
            'wave_period', 
        ];
        $prediction = NoaaPrediction::select($selectFields)
            ->where('timestamp', '=', $hour)
            ->where('noaa_station_id', $stationId)
            ->first()->toArray();

        $prediction['time_utc'] = $hour->copy()->format('g:i A');
        $prediction['time_local'] = $hour->copy()->setTimezone($tz)->format('g:i A');
        $prediction['angle'] = Helper::getDirection($prediction['swell_direction']);

        return $prediction;
    }

    /**
     * Get the predicted wind data at a given hour.
     *
     * @param Carbon $hour
     * @param string $tz
     * @param string $stationId
     * @return array
     */
    public function getWindAtHour(Carbon $hour, $tz, $stationId) : array
    {
        $selectFields = [
            'wind_direction', 
            'wind_speed'
        ];
        $prediction = NoaaPrediction::select($selectFields)
            ->where('timestamp', '=', $hour)
            ->where('noaa_station_id', $stationId)
            ->first()->toArray();

        $prediction['time_utc'] = $hour->copy()->format('g:i A');
        $prediction['time_local'] = $hour->copy()->setTimezone($tz)->format('g:i A');
        $prediction['angle'] = Helper::getDirection($prediction['wind_direction']);

        return $prediction;
    }
    
}
