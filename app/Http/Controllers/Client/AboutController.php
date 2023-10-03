<?php

namespace App\Http\Controllers\Client;

class AboutController extends ClientController
{
    public function __construct() {
        parent::__construct('review');
    }
    public function index(){
        $reviews = $this->getModel()->orderByDesc('rate')->where('rate','>=',3)->where('active',true)->limit(20)->get();
        return view("client.page.about",compact('reviews'));
    }
}
