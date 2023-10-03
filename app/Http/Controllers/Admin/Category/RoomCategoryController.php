<?php

// namespace App\Http\Controllers\Admin\Category;

// use Illuminate\Http\Request;

// class RoomCategoryController extends CategoryController
// {
    // public function __construct()
    // {
    //     parent::__construct('room_category');
    // }
    // public function index()
    // {
    //     $query = $this->getModel()
    //         ->join('images', 'room_categories.image_id', '=', 'images.id')
    //         ->select('room_categories.*', 'images.url as image_url')
    //         ->orderBy('id', 'desc');
    //     $datas = $query->paginate(10);
    //     return view("admin.page.category.room.index", compact('datas'));
    // }

    // public function store(Request $request)
    // {
    //     $data = $this->validateRoomRequest($request);
    //     if(!empty($data["image"])){
    //         $data['image_id'] = $this->uploadImage($data["image"]) ?? '1';
    //         unset($data['image']);
    //     }
    //     $created = $this->adminRepository->create($data);
    //     if($created){
    //         $slug = $created -> slug;
    //         return redirect()->route("category.room.description",$slug)->with('messenger', 1);
    //     }
    //     return redirect()->back()->with('messenger',0);
    // }

    // //view edit form with item
    // public function edit(string $slug)
    // {
    //     $data = $this->adminRepository->findBySlug($slug);
    //     return view("admin.page.category.room.edit", compact("data"));
    // }
    // //view add form
    // public function add()
    // {
    //     return view("admin.page.category.room.add");
    // }

    // public function description(string $slug)
    // {
    //     $data = $this->adminRepository->findBySlug($slug);
    //     return view("admin.page.category.room.description", compact("data"));
    // }

    // public function update(Request $request, string $slug)
    // {
    //     $data = $this->validateRoomRequest($request);
    //     $item = $this->adminRepository->findBySlug($slug);

    //     if(!empty($data["image"])){
    //         $data['image_id'] = $this->uploadImage($data["image"]) ?? ($item->image_id ?? 1);
    //         unset($data['image']);
    //     }

    //     $updated = $item->update($data);
    //     if($updated){
    //         $slug = $item -> slug;
    //         return redirect()->route("category.room.description",$slug)->with('messenger', 1);
    //     }
    //     return redirect()->back()->with('messenger',0);
    // }

    // private function validateRoomRequest(Request $request)
    // {
    //     return $request->validate([
    //         'name' => 'required|string',
    //         'cost' => 'required|numeric',
    //         'short_description' => 'required|string',
    //         'description' => 'required|string',
    //         'image' => ['nullable', 'mimes:jpeg,png'],
    //     ]);
    // }
// }
