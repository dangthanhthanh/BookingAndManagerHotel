<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GalleryController extends AdminController
{
    public function __construct()
    {
        // $this->middleware("is.manager");
        parent::__construct('gallery');
    }

    public function index(Request $request)
    {
        $query = $this->getModel();
        $datas = $query->orderByDesc('created_at')->paginate(20);
        return view('admin.page.gallery.index', compact('datas'));
    }

    public function deleteForArrayID(Request $request){
        if ($request->has('gallery_id')) {
            $arrayId = json_decode($request->gallery_id);
            $model = $this->getModel();
            foreach ($arrayId as $id) {
                $model->find($id)->delete();
            };
            $messenger = 1;
        } else {
            $messenger = 0;
        }
    
        return redirect()->route('gallery.index')->with('messenger', $messenger);
    }


    public function store(Request $request)
    {
        $bool=false;
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $data['image_id'] = $this->uploadImage($image);
                $this->adminRepository->create($data);
            }
            $bool=true;
        }
        return redirect()->route('gallery.index')->with('messenger',$bool ? 1 : 0);
    }

   
}
