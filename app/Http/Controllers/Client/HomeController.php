<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\BaseModelController;
use App\Models\Blog;
use App\Models\Gallery;
use App\Models\Review;
use App\Models\RoomCategory;

class HomeController extends ClientController
{
    public function __construct() {
        // parent::__construct();
    }
    public function index(){
        $roomCategorys= $this->getModelWithBaseModelController('room_category')->getModel()->orderByDesc('id')->where('active',true)->get();
        $reviews= $this->getModelWithBaseModelController('review')->getModel()->orderByDesc('rate')->where('rate','>=',3)->where('active',true)->limit(20)->get();
        $blogs= $this->getModelWithBaseModelController('blog')->getModel()->orderByDesc('created_at')->where('active',true)->limit(10)->get();
        $gallerys= $this->getModelWithBaseModelController('gallery')->getModel()->orderByDesc('id')->limit(20)->get();
        return view("home",compact("gallerys","roomCategorys","reviews","blogs",'gallerys'));
    }
}
