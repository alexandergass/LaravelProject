<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // $session_id = session()->getId();
        // echo $session_id;

        // echo "<br />";

        // echo $request->ip();

        // echo "<br />";

        // Session::put('ip_address', '$request->ip()');

        return view('home');
    }
}
