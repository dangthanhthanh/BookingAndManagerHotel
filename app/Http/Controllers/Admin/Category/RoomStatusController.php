<?php

namespace App\Http\Controllers\Admin\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoomStatusController extends CategoryController
{
    public function __construct()
    {
        parent::__construct('room_status');
    }
    public function index()
    {
        $datas = $this->getModel()->get();
        return view("admin.page.category.roomStatus.index", compact('datas'));
    }
}
