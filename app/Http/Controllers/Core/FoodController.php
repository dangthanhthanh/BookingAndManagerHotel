<?php

namespace App\Http\Controllers\Core;

use App\Contracts\FoodInterface;
use App\Http\Controllers\BaseModelController;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    private $repository;
    private $imageController;
    public function __construct(FoodInterface $repository,
                                ImageController $imageController)
    {
        $this -> repository = $repository;
        $this -> imageController = $imageController;
    }
    public function getAlls()
    {
        return $this->repository->getAlls();
    }
    protected function getAllIsAvailables($checkIn)
    {
        return $this->getAlls()->where('active',true);
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
    private function validateRequest($request)
    {
        return $request->validate([
            'name' => 'required|string',
            'cost' => 'required|numeric',
            'category_id' => 'required|numeric',
            'short_description' => 'required|string',
            'description' => 'required|string',
            'image' => ['nullable', 'mimes:jpeg,png'],
        ]);
    }
    protected function uploadImage($image)
    {
        return $this->imageController->uploadImage($image);
    }
    protected function setCostPercenByTime($request){
        $checkInDate = $request->input('check_in') ? Carbon::parse($request->input('check_in')) : Carbon::now();

        $costPer = $this -> getPercent($checkInDate);
        return [
            'check_in' => $checkInDate,
            'cost_per' => $costPer,
        ];
    }
    private function getPercent($time){
        $score = 1;
        return $score;
    }
}
