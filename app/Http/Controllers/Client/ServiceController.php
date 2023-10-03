<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends ClientController
{
    public function __construct() {
        parent::__construct('service');
    }
    public function index(Request $request){
        $services = $this->getModel()
            ->when($request->keyword, function ($q) use($request){
                $q->where('slug','like',"%$request->keyword%");
            })
            ->when($request->category, function ($q) use($request){
                $q->where('category_id',$this->getModelWithBaseModelController('service_category')->adminRepository->findBySlug($request->category)->id);
            })
            ->where('active',1)->orderBy('id','desc')->paginate(5);
        return view("client.page.service",compact('services'));
    }
    public function detail(string $slug){
        $data=$this->adminRepository->findBySlug($slug);
        $description=$data->description;
        $title=$data->title;
        return view("client.page.detail",compact('description','title'));
    }
}
