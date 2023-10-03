<?php

namespace App\Http\Controllers\Core;

use App\Contracts\BookingRequestInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingRequestController extends Controller
{
    private $repository;
    public function __construct(BookingRequestInterface $repository) {
        $this->repository = $repository;
    } 
    protected function getAlls(){
        return $this->repository->getAlls();
    }
    protected function getBySlug($slug){
        return $this->repository->getBySlug($slug);
    }
    public function create(string $userId, Request $request)
    {
        $this-> validateRequest($request);
        $data = [
            'customer_id' => $userId,
            'check_in' => $request['check_in'],
            'check_out' => $request['check_out'],
            'room_category_id' => $request['room_type'],
            'num_person' => $request['people'],
            'num_child' => $request['children'],
            'note' => $request['room'].'room',
            'request' => $request['request'],
        ];
        return $this->repository->create($data);
    }
    public function update(string $slug, string $statusContactId, string $note){
        $data =[
            'status_id' => $statusContactId,
            'note' => $note,
        ];
        return $this->repository->update($slug, $data);
    }

    public function delete(string $slug){
        $this->repository->delete($slug);
        return redirect()->back();
    }
    private function validateRequest($request){
        return $request -> validate([
            'room_type' => "required|string",
            'room' => "required|numeric",
            'people' => "nullable|numeric",
            'children' => "nullable|numeric",
            'check_in' => "required|date",
            'check_out' => "required|date",
            'request' => "nullable|string",
        ]);
    }
}
