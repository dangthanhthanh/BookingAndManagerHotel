<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Core\RoomStatusController as CoreRoomStatusController;

class RoomStatusController extends CoreRoomStatusController
{
    public function index()
    {
        $datas = $this->getAlls()->get();
        return view("admin.page.category.roomStatus.index", compact('datas'));
    }
}
