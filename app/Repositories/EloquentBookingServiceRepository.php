<?php

namespace App\Repositories;

use App\Contracts\BookingServiceInterface;
use App\Models\BookingService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentBookingServiceRepository implements BookingServiceInterface {
    protected $model;

    public function __construct(BookingService $model) {
        $this->model = $model;
    }

    public function getAlls() {
        return $this->model;
    }
    public function getBySlug(string $slug) {
        return $this->model->where('slug', $slug)->firstOrFail();
    }
    public function getById(string $id) {
        return $this->model->find($id);
    }
    public function create(array $data) {
        return $this->model->create($data);
    }
    public function delete(string $slug) {
        $item = $this->getBySlug($slug);
        $item->delete();
    }
}
