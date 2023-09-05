<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Gallery;
use App\Models\Review;
use App\Models\RoomCategory;

class HomeController extends Controller
{
    public function __construct() {
        // $this->middleware("redirect.notAdmin");
    }
    public function index(){
        $rooms= RoomCategory::orderBy('id','desc')->get();
        $reviews= Review::orderBy('rate','desc')->limit(5)->get();
        $blogs= Blog::orderBy('created_at','desc')->limit(10)->get();
        $gallerys= Gallery::orderBy('id','desc')->limit(10)->get();
        return view("home",compact("gallerys","rooms","reviews","blogs",'gallerys'));
    }
}
