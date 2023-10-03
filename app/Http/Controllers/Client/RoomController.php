<?php

namespace App\Http\Controllers\Client;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends ClientController
{
    public function __construct() {
        parent::__construct('room_category');
    }
    public function index(Request $request){
        $rooms=$this->getModel()
            ->when($request->keyword, function ($q) use($request){
                $q->where('slug','like',"%$request->keyword%");
            })
            ->where('active',1)->orderBy('id','desc')->paginate(5);
        return view("client.page.room",compact('rooms'));
    }
    public function detail(string $slug){
        $data=$this->adminRepository->findBySlug($slug);
        $description=$data->description;
        $title=$data->title;
        return view("client.page.detail",compact('description','title'));
    }
}
