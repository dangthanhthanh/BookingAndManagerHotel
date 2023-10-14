<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Core\EventController as CoreEventController;
use Illuminate\Http\Request;

class EventController extends CoreEventController
{
    public function index(Request $request){

        $checkDate = $this -> setCostPercenByTime($request);
        $query = $this->getAllIsAvailables($checkDate['check_in'])
            ->join('images', 'events.image_id', '=', 'images.id')
            ->when($request->has('name'), function ($query) use ($request) {
                $query->where('events.name', 'LIKE', '%' . $request->name . '%');
            })
            ->select('events.*', 'images.url as image_url')
            ->orderBy('id', 'desc');
        $datas = $query->get();
        return view("pos.page.event.index",compact('datas','checkDate'));
    }
}
