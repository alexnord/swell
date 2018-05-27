<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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
        return Report::find($id);
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
