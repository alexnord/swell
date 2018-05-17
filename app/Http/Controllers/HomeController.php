<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
     * Show the application dashboard.
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

        return view('home')->with([
            'locations' => json_encode($locations),
            'directions' => json_encode($directions),
            'tideDirs' => json_encode($tideDirs),
            'conditions' => json_encode($conditions),
        ]);
    }

    /**
     * @return \Illuminate\View\View
     */
    public function leaderboard()
    {
        $universities = \App\Models\VoteTotal::with('university')
            ->join('universities', 'universities.id', '=', 'vote_totals.university_id')
            ->orderByRaw('-(vote_totals.total_votes + vote_totals.vote_adjustment)')
            ->orderBy('universities.name', 'asc')
            ->get();
        $user = Auth::guard('voters')->user();
        $user = $user ? json_encode([
            'id' => $user->id,
        ]) : '{}';
        return view('frontend.leaderboard')->with(['universities' => $universities, 'user' => $user]);
    }
}
