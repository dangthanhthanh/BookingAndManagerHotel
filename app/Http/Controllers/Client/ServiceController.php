<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Core\ServiceController as CoreServiceController;
use Illuminate\Http\Request;

class ServiceController extends CoreServiceController
{
    public function index(Request $request){
        $services = $this->getAlls()
            ->when($request->keyword, function ($q) use($request){
                $q->where('slug','like',"%$request->keyword%");
            })
            ->when($request->category, function ($q) use($request){
                $q->where('category_id',$this->getModelWithBaseModelController('service_category')->adminRepository->findBySlug($request->category)->id);
            })
            ->where('active',1)
            ->orderBy('id','desc')
            ->paginate(5);
        return view("client.page.service",compact('services'));
    }
    public function detail(string $slug){
        $data=$this->getBySlug($slug);
        $description=$data->description;
        $title=$data->name;
        return view("client.page.detail",compact('description','title'));
    }
}
