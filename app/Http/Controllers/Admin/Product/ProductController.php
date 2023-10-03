<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\BaseModelController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $repository;
    public function __construct($repository) {
        $this->repository = $repository;
    } 
    protected function uploadImage($image)
    {
        $baseModelController = new BaseModelController();
        return $baseModelController->uploadImage($image);
    }
    protected function delete(string $slug){
        $this -> repository -> delete($slug);
        return redirect()->back();
    }
    protected function setStatus(string $slug){
        $bool = $this -> repository -> setStatus($slug);
        $rep = $bool ?  1.1 : 1.0;
        return response()->json(["rep"=>($rep)]);
    }
    protected function restore(string $slug){
        $this -> repository -> restore($slug);
        return redirect()->back();
    }
    protected function forceDelete(string $slug){
        $this -> repository -> forceDelete($slug);
        return redirect()->back();
    }
}
