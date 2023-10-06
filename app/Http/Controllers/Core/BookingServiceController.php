<?php

namespace App\Http\Controllers\Core;

use App\Contracts\BookingServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BookingServiceController extends Controller
{
    private $repository;
    public function __construct(BookingServiceInterface $repository)
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
    public function create(string $orderId, string $serviceId, $checkIn, $qty, $cost, $ratio, $note = null)
    {
        if($this->isAvailable($serviceId, $checkIn)){
            $data=[
                'order_id' => $orderId,
                'service_id' => $serviceId,
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
    // check service is active in date
    private function isAvailable(string $foodId, $checkIn)
    {
        // if($this->repository->getById($foodId)->active){
        //     return true;
        // }
        // return false;
        return true;
    }
}
