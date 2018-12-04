<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\TideData;

class TideService
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
     * Get the tide height from parameters. 
     *
     * @param string $timeBefore
     * @param string $heightBefore
     * @param string $timeAfter
     * @param string $heightAfter
     * @param string $requestedTime
     * @return string
     */
    public function getTideHeight(
        $timeBefore,
        $heightBefore,
        $timeAfter,
        $heightAfter,
        $requestedTime
    ) : string
    {
        $timeDiff = Carbon::parse($timeBefore)->diffInMinutes(Carbon::parse($timeAfter));

        $heightDiff = abs($heightBefore - $heightAfter);

        $ftPerMin = $heightDiff / $timeDiff;

        $timeDiff = $requestedTime->diffInMinutes(Carbon::parse($timeBefore));
        $tideDiff = $timeDiff * $ftPerMin;
        
        $tide = ($heightBefore > $heightAfter) ? 
            $heightBefore - $tideDiff: 
            $heightBefore + $tideDiff;
        
        return $tide;
    }

    /**
     * Get the tides for a given week.
     *
     * @param array $days
     * @param string $tz
     * @param string $stationId
     * @return array
     */
    public function getTidesForWeek(array $days, $tz, $stationId) : array
    {
        $tides = [];

        foreach ($days as $day) {
            $start = $day->copy()->setTimezone('UTC');
            $end   = $start->copy()->addDays(1);
            // dd($day, $start, $end);

            $tidesForDay = $this->getTidesForDay($start, $end, $tz, $stationId);
            // dd($tidesForDay);
            $data = [
                'day' => $day->copy()->toFormattedDateString(),
                'data' => $tidesForDay,
            ];
            $tides[] = $data;
        }

        return $tides;
    }

    /**
     * Get the tides for a given day.
     *
     * @param string $start
     * @param string $end
     * @param string $tz
     * @param string $stationId
     * @return array
     */
    public function getTidesForDay($start, $end, $tz, $stationId) : array
    {
        $tides = TideData::whereHas('station', function($query) use ($stationId) {
                $query->where('id', '=', $stationId);
            })
            ->where('timestamp', '>=', $start)
            ->where('timestamp', '<=', $end)
            ->orderBy('timestamp', 'asc')
            ->limit(4)
            ->get();

        $tidesArray = [];
        foreach ($tides as $tide) {
            $ta = $tide->toArray();
            $tideData = [
                'timestamp' => $ta['timestamp'],
                'converted_time' => (new Carbon($tide->timestamp))->setTimezone($tz)->format('g:i A'),
                'type' => $ta['type'],
                'height' => $ta['height'],
                'station_id' => $ta['noaa_station_id'],
            ];
            $tidesArray[] = $tideData;
        }

        return $tidesArray;
    }
}
