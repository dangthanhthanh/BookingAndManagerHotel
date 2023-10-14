<?php

namespace App\Http\Controllers\Core;

use App\Contracts\BookingEventInterface;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BookingEventController extends Controller
{
    private $repository;
    public function __construct(BookingEventInterface $repository)
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
    public function create(string $orderId, string $eventId, $checkIn, $qty, $cost, $ratio, $note = null)
    {
        if($this->isAvailable($eventId, $checkIn)){
            $data=[
                'order_id' => $orderId,
                'event_id' => $eventId,
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
    // check event is active in date
    private function isAvailable(string $eventId, $checkIn)
    {
        // if($this->repository->getById($foodId)->active){
        //     return true;
        // }
        // return false;
        return true;
    }
}
