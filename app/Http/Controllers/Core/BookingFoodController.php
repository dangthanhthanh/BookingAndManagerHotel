<?php

namespace App\Http\Controllers\Core;

use App\Contracts\BookingFoodInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BookingFoodController extends Controller
{
    private $repository;
    public function __construct(BookingFoodInterface $repository)
    {
        $this->repository = $repository;
    } 
    protected function getAlls()
    {
        return $this->repository->getAlls();
    }
    protected function getBySlug($slug)
    {
        return $this->repository->getBySlug($slug);
    }
    public function create(string $orderId, string $foodId, $checkIn, $qty, $cost, $ratio, $note = null)
    {
        if($this->isAvailable($foodId, $checkIn)){
            $data=[
                'order_id' => $orderId,
                'food_id' => $foodId,
                'check_in' => $checkIn,
                'qty' => $qty,
                'cost' => $cost,
                'ratio' => $ratio,
                'note' => $note,
            ];
            $this->repository->create($data);
        }
        return DB::rollBack();
    }
    public function delete(string $slug)
    {
        $this->repository->delete($slug);
        return redirect()->back();
    }
    private function isAvailable(string $foodId, $checkIn)
    {
        // if($this->repository->getById($foodId)->active){
        //     return true;
        // }
        // return false;
        return true;
    }
    
}
