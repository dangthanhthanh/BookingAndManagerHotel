<?php

namespace App\Http\Controllers\Core;

use App\Contracts\OrderInterface;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    private $repository;
    public function __construct(OrderInterface $repository)
    {
        $this -> repository = $repository;
    }
    public function getAlls()
    {
        return $this->repository->getAlls();
    }
    public function getBySlug(string $slug)
    {
        return $this->repository->getBySlug($slug);
    }
    public function getByUserId(string $userId)
    {
        return $this->repository->getByUserId($userId);
    }
    public function create(string $userId)
    {
        $data = ['customer_id' => $userId];
        return $this->repository->create($data);
    }
    public function delete(string $slug){
        $this->repository->delete($slug);
        return redirect()->back();
    }
    function foceDelete(string $slug)
    {
       $this->repository->forceDelete($slug);
       return redirect()->back();
    }
    public function restore(string $slug)
    {
        $this->repository->restore($slug);
        return redirect()->back();
    }
}
