<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Core\EventController as CoreEventController;
use Illuminate\Http\Request;

class EventController extends CoreEventController
{
    public function index(Request $request){
        $events = $this->getAlls()
            ->when($request->keyword, function ($q) use($request){
                $q->where('slug','like',"%$request->keyword%");
            })
            ->where('active',1)
            ->orderBy('id','desc')
            ->paginate(5);
        return view("client.page.event",compact('events'));
    }
    public function detail(string $slug){
        $data=$this->getBySlug($slug);
        $description=$data->description;
        $title=$data->name;
        return view("client.page.detail",compact('description','title'));
    }
}
