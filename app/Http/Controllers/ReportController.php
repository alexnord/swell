<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use Carbon\Carbon;
use App\Report;

class ReportController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Report::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = DB::table('locations')
            ->select('id as value', 'title as text')
            ->orderBy('title', 'asc')
            ->get();
        $conditions = DB::table('conditions')
            ->select('id as value', 'title as text')
            ->get();
        $userId = Auth::id();

        return view('create')->with([
            'userId' => $userId,
            'locations' => json_encode($locations),
            'conditions' => json_encode($conditions),
        ]);
    }

    /**
     * Show the all reports page.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
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

        return view('reports')->with([
            'reports' => json_encode($data),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'date' => 'required|date',

            'start_time' => 'required',
            'end_time' => 'required',

            'location_id' => 'required|integer',

            'start_swell_dir' => 'required',
            'start_swell_angle' => 'required',
            'start_swell_height' => 'required',
            'start_swell_period' => 'required',

            'end_swell_dir' => 'required',
            'end_swell_angle' => 'required',
            'end_swell_height' => 'required',
            'end_swell_period' => 'required',

            'start_wind_dir' => 'required',
            'start_wind_angle' => 'required',
            'start_wind_speed' => 'required|between:0,99.99',

            'end_wind_dir' => 'required',
            'end_wind_angle' => 'required',
            'end_wind_speed' => 'required|between:0,99.99',

            'tide_dir' => 'required',
            'start_tide_height' => 'required|between:0,99.99',
            'end_tide_height' => 'required|between:0,99.99',

            'actual_surf_height' => 'required',
            'condition_id' => 'required|integer',
            'score' => 'required|integer',
        ]);

        if ($validator->fails()) {    
            return response()->json($validator->messages(), 200);
        }

        $report = Report::create([
            'user_id' => $request->user_id,
            'date' => $request->date,

            'start_time' => $request->start_time,
            'end_time' => $request->end_time,

            'location_id' => $request->location_id,

            'start_swell_dir' => $request->start_swell_dir,
            'start_swell_angle' => $request->start_swell_angle,
            'start_swell_height' => $request->start_swell_height,
            'start_swell_period' => $request->start_swell_period,

            'end_swell_dir' => $request->end_swell_dir,
            'end_swell_angle' => $request->end_swell_angle,
            'end_swell_height' => $request->end_swell_height,
            'end_swell_period' => $request->end_swell_period,

            'start_wind_dir' => $request->start_wind_dir,
            'start_wind_angle' => $request->start_wind_angle,
            'start_wind_speed' => $request->start_wind_speed,

            'end_wind_dir' => $request->end_wind_dir,
            'end_wind_angle' => $request->end_wind_angle,
            'end_wind_speed' => $request->end_wind_speed,

            'tide_dir' => $request->tide_dir,
            'start_tide_height' => $request->start_tide_height,
            'end_tide_height' => $request->end_tide_height,

            'actual_surf_height' => $request->actual_surf_height,
            'condition_id' => $request->condition_id,
            'score' => $request->score,
            'notes' => isset($request->notes) ? $request->notes : null,
        ]);

        return response()->json([
            'success' => true,
            'data' => $report,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $report = Report::find($id);

        return view('show')->with([
            'report' => $report,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
