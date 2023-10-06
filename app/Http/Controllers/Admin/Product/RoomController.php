<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Core\RoomController as CoreRoomController;
use Illuminate\Http\Request;

class RoomController extends CoreRoomController
{
    public function index(Request $request)
    {
        $query = $this->getAlls()
            ->join('images', 'rooms.image_id', '=', 'images.id')
            ->join('room_categories', 'rooms.category_id', '=', 'room_categories.id')
            ->select('rooms.*', 'images.url as image_url', 'room_categories.name as category_name');

        $datas = $this->buildQuery($query, $request)->paginate(10);
        return view("admin.page.product.room.index", compact('datas'));
    }
    protected function buildQuery($query, $request)
    {
        return $query
        ->when($request->has('searchByName'), function ($query) use ($request) {
            $query->where('rooms.name', 'LIKE', '%' . $request->searchByName . '%');
        })
        ->when($request->has('category'), function ($query) use ($request) {
            $query->where('room_categories.slug',$request->category);
        })
        ->when($request->has('sortType') && $request->sortType === 'desc', function ($query) use ($request) {
            $query->orderByDesc($request->input('sortBy'));
        })
        ->when($request->has('sortType') && $request->sortType === 'asc', function ($query) use ($request) {
            $query->orderBy($request->input('sortBy'));
        });
    }


    public function store(Request $request)
    {
        $created = $this->createOrUpdate(null ,$request);
        return redirect()->route("room.description",$slug = $created->slug)->with('messenger', 1);
    }

    public function update(Request $request, string $slug)
    {
        $updated = $this->createOrUpdate($slug ,$request);
        return redirect()->route("room.description",$slug = $updated->slug)->with('messenger', 1);
    }

    public function edit(string $slug)
    {
        return view("admin.page.product.room.edit")->with(['data' => $this->getBySlug($slug)]);
    }
    public function add()
    {
        return view("admin.page.product.room.add");
    }

    public function description(string $slug)
    {
        return view("admin.page.product.room.description")->with(['data' => $this->getBySlug($slug)]);
    }
}
