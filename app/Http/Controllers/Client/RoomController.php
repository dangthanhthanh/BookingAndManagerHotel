<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends ClientController
{
    public function __construct() {
        parent::__construct('room_category');
        // $this->middleware("redirect.notAdmin");
    }
    public function index(){
        $rooms=Room::orderBy('id','desc')->where('active',1)->paginate(5);
        return view("client.page.room",compact('rooms'));
    }
    public function show(string $id){
        $data=Room::select('description','title')->find($id);
        $description=$data->description;
        $title=$data->title;
        return view("client.page.detail",compact('description','title'));
    }
}
