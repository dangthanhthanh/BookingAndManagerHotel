<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Core\ReviewController;

class AboutController extends ReviewController
{
    public function index(){
        $reviews = $this->getAlls()->orderByDesc('rate')->where('rate','>=',3)->where('active',true)->limit(20)->get();
        return view("client.page.about",compact('reviews'));
    }
}
