<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\NoaaStation;
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
     * Get the current tide height for a locaiton.
     *
     * @param NoaaStation $station
     * @param string $tz
     * @return array
     */
    public function getLatestTide(NoaaStation $station, $tz) : array
    {
        $now = Carbon::now()->setTimezone('UTC');
        $height = $this->getHeightAtHour($now, $tz, $station->id);

        $height['height'] = round($height['height'], 1);
        $height['station_name'] = $station->title;
        return $height;
    }

    /**
     * Get the hourly breakdown of tide data for a given week.
     *
     * @param Carbon $dayMidnight
     * @param string $tz
     * @param string $stationId
     * @return array
     */
    public function getHourlyBreakdownForWeek(Carbon $dayMidnight, $tz, $stationId) : array
    {
        $data = [];
        for ($i=0; $i < 7 ; $i++) {
            $hourlyForDay = $this->getHourlyBreakdown($dayMidnight->copy()->addDays($i), $tz, $stationId);
            $data[] = [
                'date' => $dayMidnight->copy()->addDays($i)->toDayDateTimeString(),
                'data' => $hourlyForDay
            ];
        }

        return $data;
    }

    /**
     * Get the height for a tide at a given hour.
     *
     * @param Carbon $hour
     * @param string $tz
     * @param string $stationId
     * @return array
     */
    public function getHeightAtHour(Carbon $hour, $tz, $stationId) : array
    {        
        $tideBeforeStart = TideData::select('height', 'timestamp')
            ->where('timestamp', '<=', $hour)
            ->where('noaa_station_id', $stationId)
            ->orderBy('timestamp', 'desc')
            ->first()->toArray();
        $tideAfterStart = TideData::select('height', 'timestamp')
            ->where('timestamp', '>=', $hour)
            ->where('noaa_station_id', $stationId)
            ->orderBy('timestamp', 'asc')
            ->first()->toArray();

        $height = $this->getTideHeight(
            $tideBeforeStart['timestamp'],
            $tideBeforeStart['height'],
            $tideAfterStart['timestamp'],
            $tideAfterStart['height'],
            $hour
        );

        $direction = $tideBeforeStart < $tideAfterStart ?
            'rising' : 'falling';

        $data = [
            'time_utc' => $hour->copy()->format('g:i A'),
            'time_local' => $hour->copy()->setTimezone($tz)->format('g:i A'),
            'height' => round($height, 2),
            'direction' => $direction,
        ];

        return $data;
    }

    /**
     * Get the hourly breakdown of tide data for a given day.
     *
     * @param Carbon $dayMidnight
     * @param string $tz
     * @param string $stationId
     * @return array
     */
    public function getHourlyBreakdown(Carbon $dayMidnight, $tz, $stationId) : array
    {
        $hours = $this->getHours($dayMidnight, $tz, $stationId);

        $data = [];
        foreach ($hours as $hour) {
            $tideBeforeStart = TideData::select('height', 'timestamp')
                ->where('timestamp', '<=', $hour)
                ->where('noaa_station_id', $stationId)
                ->orderBy('timestamp', 'desc')
                ->first()->toArray();
            $tideAfterStart = TideData::select('height', 'timestamp')
                ->where('timestamp', '>=', $hour)
                ->where('noaa_station_id', $stationId)
                ->orderBy('timestamp', 'asc')
                ->first()->toArray();

            $height = $this->getTideHeight(
                $tideBeforeStart['timestamp'],
                $tideBeforeStart['height'],
                $tideAfterStart['timestamp'],
                $tideAfterStart['height'],
                $hour
            );

            $data[] = [
                // 'carbon_date' => $hour,
                // 'timestamp_utc' => $hour->copy()->toDayDateTimeString(),
                // 'timestamp_local' => $hour->copy()->setTimezone($tz)->toDayDateTimeString(),
                'time_utc' => $hour->copy()->format('g:i A'),
                'time_local' => $hour->copy()->setTimezone($tz)->format('g:i A'),
                'height' => round($height, 2),
            ];
        }

        // Add the direction of the tide to the array values
        foreach ($data as $index => $datum) {

            $direction = '';
            if(isset($data[$index+1]['height'])) {
                $direction = $data[$index]['height'] < $data[$index+1]['height'] ?
                    'rising' : 'falling';
            }
            $data[$index]['direction'] = $direction;
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

            $tidesForDay = $this->getTidesForDay($start, $end, $tz, $stationId);
            $data = [
                'day' => $day->copy()->format('l, F jS Y'),
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
            $tideData = [
                'timestamp' => $tide->timestamp,
                'converted_time' => (new Carbon($tide->timestamp))->setTimezone($tz)->format('g:i A'),
                'type' => $tide->type,
                'height' => round($tide->height, 1),
                'station_id' => $tide->noaa_staiton_id,
            ];
            $tidesArray[] = $tideData;
        }

        return $tidesArray;
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

        $ftPerMin = $timeDiff === 0 ?
            $heightDiff : $heightDiff / $timeDiff;

        $timeDiff = $requestedTime->diffInMinutes(Carbon::parse($timeBefore));
        $tideDiff = $timeDiff * $ftPerMin;
        
        $tide = ($heightBefore > $heightAfter) ? 
            $heightBefore - $tideDiff: 
            $heightBefore + $tideDiff;
        
        return $tide;
    }
}
