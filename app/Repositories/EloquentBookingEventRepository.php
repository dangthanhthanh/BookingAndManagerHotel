<?php

namespace App\Repositories;

use App\Contracts\BookingEventInterface;
use App\Models\BookingEvent;

class EloquentBookingEventRepository implements BookingEventInterface {
    protected $model;

    public function __construct(BookingEvent $model) {
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
