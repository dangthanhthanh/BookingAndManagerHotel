<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Core\RoomCategoryController as CoreRoomCategoryController;
use Illuminate\Http\Request;

class RoomCategoryController extends CoreRoomCategoryController
{
    public function index()
    {
        $query = $this->getAlls()
            ->join('images', 'room_categories.image_id', '=', 'images.id')
            ->select('room_categories.*', 'images.url as image_url')
            ->orderBy('id', 'desc');
        $datas = $query->paginate(10);
        return view("admin.page.category.room.index", compact('datas'));
    }

    public function store(Request $request)
    {
        $created = $this->createOrUpdate(null, $request);
        return redirect()->route("category.room.description",$slug = $created->update)->with('messenger', 1);
    }
    public function update(Request $request, string $slug)
    {
        $updated = $this->createOrUpdate($slug, $request);
        return redirect()->route("category.room.description",$slug = $updated -> slug)->with('messenger', 1);
    }
    public function edit(string $slug)
    {
        return view("admin.page.category.room.edit")->with(['data' => $this->getBySlug($slug)]);
    }
    public function add()
    {
        return view("admin.page.category.room.add");
    }
    public function description(string $slug)
    {
        return view("admin.page.category.room.description")->with(['data' => $this->getBySlug($slug)]);
    }
}
