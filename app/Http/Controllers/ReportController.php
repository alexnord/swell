<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Report;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return;
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
            ->get();
        $directions = DB::table('directions')
            ->select('id as value', 'title as text')
            ->get();
        $tideDirs = DB::table('tides')
            ->select('id as value', 'title as text')
            ->get();
        $conditions = DB::table('conditions')
            ->select('id as value', 'title as text')
            ->get();

        return view('home')->with([
            'locations' => json_encode($locations),
            'directions' => json_encode($directions),
            'tideDirs' => json_encode($tideDirs),
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
            'time' => 'required',
            'location_id' => 'required|integer',
            'swell_dir_id' => 'required|integer',
            'swell_angle' => 'required|integer',
            'swell_height' => 'required|between:0,99.99',
            'swell_period' => 'required|integer',
            'wind_dir_id' => 'required|integer',
            'wind_speed' => 'required|between:0,99.99',
            'tide_dir_id' => 'required|integer',
            'tide_height' => 'required|between:0,99.99',
            'actual_surf_height' => 'required',
            'condition_id' => 'required|ineger',
            'score' => 'required|integer',
            'notes' => 'required',
        ]);

        dd($validator->errors());

        if ($validator->fails()) {
            return redirect('post/create')
                        ->withErrors($validator)
                        ->withInput();
        }


        $report = Report::create([
            'date' => $request->date,
            'time' => $request->time,
            'location_id' => $request->location_id,
            'swell_dir_id' => $request->swell_dir_id,
            'swell_angle' => $request->swell_angle,
            'swell_height' => $request->swell_height,
            'swell_period' => $request->swell_period,
            'wind_dir_id' => $request->wind_dir_id,
            'wind_speed' => $request->wind_speed,
            'tide_dir_id' => $request->tide_dir_id,
            'tide_height' => $request->tide_height,
            'actual_surf_height' => $request->actual_surf_height,
            'condition_id' => $request->condition_id,
            'score' => $request->score,
            'notes' => $request->notes,
        ]);

        dd($report);
        return $report;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
