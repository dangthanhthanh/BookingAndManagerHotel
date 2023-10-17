<?php

namespace App\Http\Controllers\Core;

use App\Contracts\BookingRoomInterface;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\RoomController;

class BookingRoomController extends Controller
{
    private $repository;
    private $roomController;
    public function __construct(
        BookingRoomInterface $repository,
        RoomController $roomController)
    {
        $this->repository = $repository;
        $this->roomController = $roomController;
    } 
    protected function getAlls()
    {
        return $this->repository->getAlls();
    }
    protected function getBySlug($slug)
    {
        return $this->repository->getBySlug($slug);
    }
    public function create(string $orderId, $roomId, string $roomStatusId, $checkIn, $checkOut, $manyPer, $cost, $ratio, $request=null, $note = null)
    {
        if($this->isAvailable($roomId, $checkIn, $checkOut)){
            $data = [
                'order_id' => $orderId,
                'room_id' => $roomId,
                'room_status_id' => $roomStatusId,
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'number_per' => $manyPer,
                'cost' => $cost,
                'ratio' => $ratio,
                'cus_request' => $request,
                'note' => $note,
            ];
            return $this->repository->create($data)
            ? true 
            : false;
        }
        throw new \Exception('booking room creation failed.');
    }
    public function delete(string $slug)
    {
        $this->repository->delete($slug);
        return redirect()->back();
    }
    public function isAvailable($roomId, $checkIn, $checkOut)
    {
        $room = $this->roomController->getById($roomId);
        return  $room -> isAvailable($checkIn, $checkOut);
    }
}
