<?php

namespace App\Http\Controllers\Pos;

use Illuminate\Http\Request;

class RoomController extends PosController
{
    public function __construct() {
        parent::__construct('room');
    }
    public function index(Request $request){
        $query = $this->getModel()
            ->join('images', 'rooms.image_id', '=', 'images.id')
            ->join('room_categories', 'rooms.category_id', '=', 'room_categories.id')
            ->select('rooms.*', 'images.url as image_url', 'room_categories.name as category_name')
            ->orderBy('id', 'desc');
        $datas = $query->get();
        return view("pos.page.room.index",compact('datas'));
    }
}
