<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends ClientController
{
    public function __construct() {
        parent::__construct('service');
        // $this->middleware("redirect.notAdmin");

    }
    public function index(){
        $services=Service::orderBy('id','desc')->where('active',1)->paginate(5);
        return view("client.page.service",compact('services'));
    }
    public function show(string $id){
        $data=Service::select('description','title')->find($id);
        $description=$data->description;
        $title=$data->title;
        return view("client.page.detail",compact('description','title'));
    }
}
