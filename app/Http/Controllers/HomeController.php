<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use Carbon\Carbon;
use App\Report;

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
        $reports = Report::all();

        $data = [];
        foreach ($reports as $report) {

            // Date
            $date = Carbon::parse($report->date);

            // Swell
            $avgSwellAngle = $report->end_swell_angle ?
                ($report->start_swell_angle + $report->end_swell_angle)/2 :
                $report->start_swell_angle;
            $avgSwellDir = Helper::getDirection($avgSwellAngle);
            $swellDir = $avgSwellAngle.'° '.$avgSwellDir;
            $avgSwellHeight = $report->end_swell_height ? 
                ($report->start_swell_height + $report->end_swell_height)/2 :
                $report->start_swell_height;
            $avgSwellPeriod = $report->end_swell_period ? 
                ($report->start_swell_period + $report->end_swell_period)/2 :
                $report->start_swell_period;
            $swellHeight = $avgSwellPeriod .'s'.' '.$avgSwellHeight.'ft';

            // Wind
            $avgWindSpeed = $report->end_wind_speed ? 
                ($report->start_wind_speed + $report->end_wind_speed)/2 :
                $report->start_wind_speed;
            $avgWindAngle = $report->end_wind_angle? 
                ($report->start_wind_angle + $report->end_wind_angle)/2 :
                $report->start_wind_angle;
            $avgWindDir = Helper::getDirection($avgWindAngle);
            $wind = $avgWindSpeed.'mph '.$avgWindDir;

            // Tide
            $tide = $report->tide_dir;

            $data[] = [
                'id' => $report->id,
                'date' => $report->date,
                'spot' => $report->location->title,
                'angle' => $swellDir,
                'height' => $swellHeight,
                'tide' => $tide,
                'wind' => $wind,
                'conditions' => $report->conditions->title,
                'score' => $report->score,
            ];
        }

        usort($data, function ($a, $b) {
            return $b['date'] <=> $a['date'];
        });

        return view('home')->with([
            'reports' => json_encode($data),
        ]);
    }
}
