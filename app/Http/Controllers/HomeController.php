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
        $buoy = BuoyData::whereHas('buoy', function ($query) {
                $query->where('id', '=', 1);
            })
            ->orderBy('timestamp', 'desc')
            ->first();

        $todayDate = (new Carbon())->format('Ymd');
        $tomorrowDate = (new Carbon())->addDays(1)->format('Ymd');

        $tides = TideData::whereHas('station', function ($query) {
                $query->where('id', '=', 1);
            })
            ->where('timestamp', '>=', $todayDate)
            ->where('timestamp', '<', $tomorrowDate)
            ->orderBy('timestamp', 'asc')
            ->limit(4)
            ->get();

        $tidesArray = [];
        foreach ($tides as $tide) {
            $ta = $tide->toArray();
            $ta['converted_time'] = (new Carbon($tide->timestamp))->format('g:i A');
            $tidesArray[] = $ta;

        }

        $data = [
            'buoy' => $buoy->toArray(),
            'tides' => $tidesArray,
        ];

        return view('home')->with([
            'data' => json_encode($data),
        ]);
    }
}
