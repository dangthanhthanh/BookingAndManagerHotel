<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    public function index()
    {
        // $rooms= RoomCategory::orderBy('id','desc')->get();
        // $reviews= Review::orderBy('rate','desc')->limit(5)->get();
        // $blogs= Blog::orderBy('id','desc')->limit(10)->get();
        // $gallerys= Gallery::orderBy('id','desc')->limit(10)->get();
        // return view("home",compact("gallerys","rooms","reviews","blogs",'gallerys'));
    }
}
