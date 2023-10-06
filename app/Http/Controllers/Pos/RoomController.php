<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Core\RoomController as CoreRoomController;
use Illuminate\Http\Request;
class RoomController extends CoreRoomController
{
    public function index(Request $request){
        $checkDate = $this -> setCostPercenByTime($request);
        $query = $this->getAllIsAvailables($checkDate['check_in'],$checkDate['check_out'])
            ->join('images', 'rooms.image_id', '=', 'images.id')
            ->join('room_categories', 'rooms.category_id', '=', 'room_categories.id')
            ->when($request->has('category'), function ($query) use ($request) {
                $query->where('room_categories.slug',$request->category);
            })
            ->when($request->has('name'), function ($query) use ($request) {
                $query->where('rooms.name', 'LIKE', '%' . $request->name . '%');
            })
            ->select('rooms.*', 'images.url as image_url', 'room_categories.name as category_name')
            ->orderBy('id','asc');
        $datas = $query->get();
        return view("pos.page.room.index",compact( 'datas', 'checkDate'));
    }
}
