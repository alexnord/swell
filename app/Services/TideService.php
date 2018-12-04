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

    public function getTideHeight(
        $timeBefore,
        $heightBefore,
        $timeAfter,
        $heightAfter,
        $requestedTime
    )
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
}
