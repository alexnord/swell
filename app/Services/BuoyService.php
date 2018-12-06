<?php

namespace App\Services;

use Carbon\Carbon;
use App\Helpers\Helper;
use App\Models\Buoy;
use App\Models\BuoyData;

class BuoyService
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
     * Get the latest buoy data for a given buoy.
     *
     * @param Buoy $buoy
     * @param string $limit
     * @param string $tz
     * @return array
     */
    public function getLatestBuoyData(Buoy $buoy, string $limit, string $tz) : array
    {
        $data = BuoyData::whereHas('buoy', function ($query) use ($buoy) {
                $query->where('id', '=', $buoy->id);
            })
            ->orderBy('timestamp', 'desc')
            ->limit(10)
            ->get();

        $formattedData = [];
        foreach ($data as $datum) {
            $formattedData[] = [
                'timestamp' => $datum->timestamp,
                'time_utc' => Carbon::parse($datum->timestamp)->copy()->format('g:i A'),
                'time_local' => Carbon::parse($datum->timestamp)->setTimezone($tz)->copy()->format('g:i A'),
                'wave_height' => round($datum->wave_height, 1),
                'dominant_period' => round($datum->dominant_period, 0),
                'angle' => round($datum->angle, 0),
                'water_temp' => round($datum->water_temp, 0),
                'direction' => Helper::getDirection($datum->angle),
                'name' => $datum->buoy->title,
            ];
        }

        return $formattedData;
    }
}
