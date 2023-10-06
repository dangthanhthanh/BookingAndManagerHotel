<?php

namespace App\Http\Controllers\Core;

use App\Contracts\BlogInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    private $repository;
    private $imageController;
    public function __construct(BlogInterface $repository,
                                ImageController $imageController)
    {
        $this -> repository = $repository;
        $this -> imageController = $imageController;
    }
    public function getAlls()
    {
        return $this->repository->getAlls();
    }
    public function getBySlug($slug)
    {
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
    public function delete(string $slug)
    {
        $this->repository->delete($slug);
        return redirect()->back();
    }
    public function foceDelete(string $slug)
    {
       $this->repository->forceDelete($slug);
       return redirect()->back();
    }
    public function restore(string $slug)
    {
        $this->repository->restore($slug);
        return redirect()->back();
    }
    protected function setStatus(string $slug)
    {
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
            'image' => ['nullable', 'mimes:jpeg,png'],
            'category_id' => 'required|numeric',
            'short_description' => 'required|string',
            'description' => 'required|string',
        ]);
    }
    protected function uploadImage($image)
    {
        return $this->imageController->uploadImage($image);
    }
}
