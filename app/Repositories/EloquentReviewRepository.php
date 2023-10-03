<?php

namespace App\Repositories;

use App\Contracts\ReviewInterface;
use App\Models\Review;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentReviewRepository implements ReviewInterface {
    protected $model;

    public function __construct(Review $model) {
        $this->model = $model;
    }

    public function getAlls() {
        return $this->model;
    }

    public function getBySlug(string $slug) {
        return $this->model->where('slug', $slug)->firstOrFail();
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

    public function setStatus(string $slug) {   
        $item = $this->getBySlug($slug);
        $item->update(['active' => !$item->active]);
        return $item;
    }
}
