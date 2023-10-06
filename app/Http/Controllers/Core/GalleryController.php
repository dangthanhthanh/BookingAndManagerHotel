<?php

namespace App\Http\Controllers\Core;

use App\Contracts\GalleryInterface;
use App\Http\Controllers\BaseModelController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    private $repository;
    private $imageController;
    public function __construct(GalleryInterface $repository,
                                ImageController $imageController)
    {
        $this->repository = $repository;
        $this->imageController = $imageController;
    } 
    public function getAlls()
    {
        return $this->repository->getAlls();
    }
    public function getById(string $id)
    {
        return $this->repository->getById($id);
    }
    public function create(Request $request)
    {
        $bool = $this->repository->create($this->validateRequest($request));
        return redirect()->back()->with('messenger', $bool ? 1 : 0);
    }
    public function deleteForArrayID(Request $request)
    {
        if ($request->has('gallery_id')) {
            $arrayId = json_decode($request->gallery_id);
            foreach ($arrayId as $id) {
                $this->repository->delete($id);
            };
            return redirect()->back()->with('messenger',1);
        }
        return redirect()->back()->with('messenger',0);
    }
    public function store(Request $request)
    {
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $this->repository->create(['image_id' => $this->uploadImage($image)]);
            }
            return redirect()->back()->with('messenger',1);
        }
        return redirect()->back()->with('messenger',0);
    }
    protected function uploadImage($image)
    {
        return $this->imageController->uploadImage($image);
    }
}
