<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
            $date = Carbon::parse($report->date);
            
            $swellDir = $report->swell_angle.'° '.$report->swellDir->title;
            $swellHeight = $report->swell_period.'s'.' '.$report->swell_height.'ft';
            $wind = $report->wind_speed.'mph '.$report->windDir->title;
            $tide = $report->tide_height.'ft '.$report->tideDir->title;
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

        return view('home')->with([
            'reports' => json_encode($data),
        ]);
    }
}
