<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\NoaaPrediction;
use App\Services\TideService;
use App\Models\WeatherForecast;
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
        $prediction['swell_height'] = round($prediction['swell_height'], 1);
        $prediction['swell_period'] = round($prediction['swell_period'], 0);
        $prediction['swell_direction'] = round($prediction['swell_direction'], 0);
        $prediction['wave_height'] = round($prediction['wave_height'], 1);
        $prediction['wave_period'] = round($prediction['wave_period'], 0);

        return $prediction;
    }

    /**
     * Get the predicted wind data at a given hour.
     *
     * @param Carbon $hour
     * @param string $tz
     * @param Location $location
     * @return array
     */
    public function getWeatherAtHour(Carbon $hour, $tz, $location) : array
    {

        // Get the forecast data from DarkSky if available
        $prediction = WeatherForecast::where('timestamp', '=', $hour)
            ->where('location_id', $location->id)
            ->first();

        if (isset($prediction)) {
            $prediction = $prediction->toArray();
            $prediction['time_utc'] = $hour->copy()->format('g:i A');
            $prediction['time_local'] = $hour->copy()->setTimezone($tz)->format('g:i A');
            $prediction['observation_time'] = $prediction['observation_time'];
            $prediction['angle'] = Helper::getDirection($prediction['angle']);
            $prediction['wind_speed'] = round($prediction['speed'], 0);
            $prediction['temperature'] = $prediction['temperature'];
            $prediction['text'] = $prediction['text'];

        } else {
            // If DarkSky data is unavailable (it can only forecast 48 hours)
            // then get the StormGlass prediction
            $prediction = NoaaPrediction::where('timestamp', '=', $hour)
                ->where('noaa_station_id', $location->station->id)
                ->first()->toArray();

            $prediction['time_utc'] = $hour->copy()->format('g:i A');
            $prediction['time_local'] = $hour->copy()->setTimezone($tz)->format('g:i A');
            $prediction['angle'] = Helper::getDirection($prediction['wind_direction']);
            $prediction['wind_speed'] = round($prediction['wind_speed'], 0);
        }

        return $prediction;
    }
    
}
