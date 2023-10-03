<?php

namespace App\Http\Controllers\Core;

use App\Contracts\HotelInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    chua song
    private $repository;
    public function __construct(HotelInterface $repository) {
        $this -> repository = $repository;
    }
    protected function getAlls(){
        return $this->repository->getAlls();
    }
    protected function getBySlug($slug){
        return $this->repository->getBySlug($slug);
    }
    protected function createOrUpdate(string $slug = null, Request $request)
    {
        $data = $this->processRequestData($request);
        if (!is_null($slug)) {
            return $this->repository->update($slug, $data);
        }
        return $this->repository->create($data);
    }
    public function delete(string $slug){
        $this->repository->delete($slug);
        return redirect()->back();
    }
    public function foceDelete(string $slug){
       $this->repository->forceDelete($slug);
       return redirect()->back();
    }
    public function restore(string $slug){
        $this->repository->restore($slug);
        return redirect()->back();
    }
    public function setStatus(string $slug){
        $bool = $this ->repository-> setStatus($slug);
        $rep = $bool ?  1.1 : 1.0;
        return response()->json(["rep"=>($rep)]);
    }
    protected function processRequestData(Request $request)
    {
        $data = $this->validateRequest($request);
        if (!empty($data['image'])) {
            $data['image_id'] = $this->uploadImage($data['image']);
            unset($data['image']);
        }
        return $data;
    }
    private function validateRequest($request){
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
    // protected function uploadImage($image)
    // {
    //     $baseModelController = new BaseModelController();
    //     return $baseModelController->uploadImage($image);
    // }
}
