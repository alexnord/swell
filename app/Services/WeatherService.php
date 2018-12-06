<?php

namespace App\Services;

use Carbon\Carbon;
use App\Helpers\Helper;
use App\Models\Location;
use App\Models\WeatherData;

class WeatherService
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
     * Get the latest weather data for a given location.
     *
     * @param Location $location
     * @param string $limit
     * @param string $tz
     * @return array
     */
    public function getWeatherData(Location $location, string $limit, string $tz) : array
    {
        $data = WeatherData::whereHas('location', function ($query) use ($location) {
                $query->where('id', '=', $location->id);
            })
            ->orderBy('timestamp', 'desc')
            ->limit($limit)
            ->get();

        $formattedData = [];
        foreach ($data as $datum) {
            $formattedData[] = [
                'name' => $datum->location->title,
                'timestamp' => $datum->timestamp,
                'time_utc' => Carbon::parse($datum->timestamp)->copy()->format('g:i A'),
                'time_local' => Carbon::parse($datum->timestamp)->setTimezone($tz)->copy()->format('g:i A'),
                'speed' => round($datum->speed, 0),
                'angle' => round($datum->angle, 0),
                'direction' => Helper::getDirection($datum->angle),
            ];
        }

        return $formattedData;
    }
}
