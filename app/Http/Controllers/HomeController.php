<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use Carbon\Carbon;
use App\Models\BuoyData;
use App\Models\TideData;

class HomeController extends Controller
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
     * Show the create entry form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userTz = Auth::user()->timezone;

        $todayYearForUser  = Carbon::now($userTz)->format('Y');
        $todayMonthForUser = Carbon::now($userTz)->format('m');
        $todayDayForUser   = Carbon::now($userTz)->format('d');

        $midnightTodayUser = Carbon::create($todayYearForUser, $todayMonthForUser, $todayDayForUser, 0, 0, 0, 'America/Los_Angeles');
        $midnightTodayUser2 = Carbon::create($todayYearForUser, $todayMonthForUser, $todayDayForUser, 0, 0, 0, 'America/Los_Angeles');

        $midinightTomorrowUser = $midnightTodayUser->addHours(24);
        
        $utcToday    = $midnightTodayUser2->setTimezone('UTC');
        $utcTomorrow = $midinightTomorrowUser->setTimezone('UTC');

        $buoy  = $this->getBuoyData();
        $tides = $this->getTIdes($utcToday, $utcTomorrow, $userTz);

        $data = [
            'buoy' => $buoy,
            'tides' => $tides,
            'date' => $midnightTodayUser->toFormattedDateString(),
        ];

        return view('home')->with([
            'data' => json_encode($data),
        ]);
    }

    private function getBuoyData()
    {
        $buoy = BuoyData::whereHas('buoy', function ($query) {
                $query->where('id', '=', 1);
            })
            ->orderBy('timestamp', 'desc')
            ->first();

        return $buoy->toArray();
    }

    private function getTides($utcToday, $utcTomorrow, $userTz)
    {
        $tides = TideData::whereHas('station', function ($query) {
                $query->where('id', '=', 1);
            })
            ->where('timestamp', '>=', $utcToday)
            ->where('timestamp', '<=', $utcTomorrow)
            ->orderBy('timestamp', 'asc')
            ->limit(4)
            ->get();

        $tidesArray = [];
        foreach ($tides as $tide) {
            $ta = $tide->toArray();
            $ta['converted_time'] = (new Carbon($tide->timestamp))->setTimezone($userTz)->format('g:i A');
            $tidesArray[] = $ta;
        }

        return $tidesArray;
    }
}
