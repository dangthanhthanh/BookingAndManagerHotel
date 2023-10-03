<?php

namespace App\Repositories;

use App\Contracts\OrderInterface;
use App\Models\Order;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentOrderRepository implements OrderInterface {
    protected $model;

    public function __construct(Order $model) {
        $this->model = $model;
    }

    public function getAlls() {
        return $this->model;
    }

    public function getBySlug(string $slug) {
        return $this->model->where('slug', $slug)->firstOrFail();
    }

    public function getByUserId(string $id) {
        return $this->model->where('customer_id', $id)->get();
    }

    public function create(array $data) {
        return $this->model->create($data);
    }

    public function update(string $slug, array $data) {
        $item = $this->getBySlug($slug);
        $item->update($data);
        return $item;
    }

    public function delete(string $slug) {
        $item = $this->getBySlug($slug);
        $item->delete();
    }

    public function forceDelete(string $slug) {
        $item = $this->getBySlug($slug);
        $item->forceDelete();
    }
   
    public function restore(string $slug) {
        $item = $this->getBySlug($slug);
        $item->restore();
    }   

}
