<?php

namespace App\Http\Controllers\Client;

use App\Models\Food;

class FoodController extends ClientController
{
    public function __construct() {
        parent::__construct('food');
        // $this->middleware("redirect.notAdmin");
    }
    public function index(){
        $foods=Food::orderBy('id','desc')->where('active',1)->paginate(5);
        return view("client.page.food",compact('foods'));
    }
    public function show(string $id){
        $data=Food::select('description','title')->find($id);
        $description=$data->description;
        $title=$data->title;
        return view("client.page.detail",compact('description','title'));
    }
}
