<?php

namespace App\Http\Controllers\Core;

use App\Contracts\RoomInterface;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    private $repository;
    private $imageController;
    public function __construct(RoomInterface $repository,
                                ImageController $imageController)
    {
        $this -> repository = $repository;
        $this -> imageController = $imageController;
    }
    protected function getAlls()
    {
        return $this->repository->getAlls();
    }
    protected function getAllIsAvailables($checkIn,$checkOut)
    {
        $rooms=[];
        foreach ($this->getAlls()->get() as $item) {
            if($item->isAvailable($checkIn, $checkOut)){
                $rooms[]=$item->id;
            }
        }
        return $this->getAlls()->whereIn('rooms.id',$rooms);
    }
    public function getById(string $id)
    {
        return $this->repository->getById($id);
    }
    protected function getBySlug($slug)
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
    public function setStatus(string $slug)
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
            'capacity' => 'required|numeric',
            'bed' => 'required|numeric',
            'description' => 'required|string',
            'image' => ['nullable', 'mimes:jpeg,png'],
        ]);
    }
    protected function uploadImage($image)
    {
        return $this->imageController->uploadImage($image);
    }
    //set percent cost by time use
    protected function setCostPercenByTime($request){
        $checkInDate = $request->input('check_in') ? Carbon::parse($request->input('check_in')) : Carbon::now()->addMinutes(30);
        $checkOutDate = $request->input('check_out') ? Carbon::parse($request->input('check_out')) : Carbon::now()->addDays(1)->addMinutes(30);
        $difDay = $checkInDate->diffInHours($checkOutDate);
        $costPer = $this -> getPercent($difDay);
        return [
            'check_in' => $checkInDate,
            'check_out' => $checkOutDate,
            'cost_per' => $costPer,
        ];
    }
    private function getPercent($difDay){
        $interNum = floor($difDay / 24);
        $surplus = $difDay % 24;
        if($surplus > 0 && $surplus <= 24) {
            if($surplus <= 4){
                $score = 0;
            }elseif($surplus <= 12){
                $score = 0.5;
            }elseif($surplus <= 18){
                $score = 0.8;
            }else{
                $score = 1;
            }
            return $score + $interNum; 
        }
        return $interNum;
    }
}
