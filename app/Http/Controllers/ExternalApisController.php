<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Noaa;
use App\Location;

class ExternalApisController extends Controller
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
     * Do something.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return;
    }
}
