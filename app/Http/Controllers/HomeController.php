<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
        $userId = Auth::id();

        return view('home')->with([
            'userId' => $userId,
            'locations' => json_encode($locations),
            'directions' => json_encode($directions),
            'tideDirs' => json_encode($tideDirs),
            'conditions' => json_encode($conditions),
        ]);
    }
}
