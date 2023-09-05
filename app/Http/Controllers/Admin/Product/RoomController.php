<?php

namespace App\Http\Controllers\Admin\Product;

use Illuminate\Http\Request;

class RoomController extends ProductController
{
    public function __construct()
    {
        parent::__construct('room');
    }
    public function index(Request $request)
    {
        $query = $this->getModel()
            ->join('images', 'rooms.image_id', '=', 'images.id')
            ->join('room_categories', 'rooms.category_id', '=', 'room_categories.id')
            ->select('rooms.*', 'images.url as image_url', 'room_categories.name as category_name');

        $datas = $query
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
            })
            ->paginate(10);
        return view("admin.page.product.room.index", compact('datas'));
    }

    public function store(Request $request)
    {
        $data = $this->validateRoomRequest($request);
        if(!empty($data["image"])){
            $data['image_id'] = $this->uploadImage($data["image"]) ?? '1';
            unset($data['image']);
        }
        $created = $this->adminRepository->create($data);
        if($created){
            $slug = $created -> slug;
            return redirect()->route("room.description",$slug)->with('messenger', 1);
        }
        return redirect()->back()->with('messenger',0);
    }

    public function update(Request $request, string $slug)
    {
        $data = $this->validateRoomRequest($request);
        $item = $this->adminRepository->findBySlug($slug);

        if(!empty($data["image"])){
            $data['image_id'] = $this->uploadImage($data["image"]) ?? ($item->image_id ?? 1);
            unset($data['image']);
        }
        $updated = $item->update($data);
        if($updated){
            $slug = $item -> slug;
            return redirect()->route("room.description",$slug)->with('messenger', 1);
        }
        return redirect()->back()->with('messenger',0);
    }

    public function edit(string $slug)
    {
        $data = $this->adminRepository->findBySlug($slug);
        return view("admin.page.product.room.edit", compact("data"));
    }
    public function add()
    {
        return view("admin.page.product.room.add");
    }

    public function description(string $slug)
    {
        $data = $this->adminRepository->findBySlug($slug);
        return view("admin.page.product.room.description", compact("data"));
    }

    private function validateRoomRequest(Request $request)
    {
        return $request->validate([
            'name' => 'required|string',
            'cost' => 'required|numeric',
            'category_id' => 'required|numeric',
            'capacity' => 'required|numeric',
            'bed' => 'required|numeric',
            'description' => 'required|string',
            'image' => ['nullable', 'mimes:jpeg,png'],
        ]);
    }
}
