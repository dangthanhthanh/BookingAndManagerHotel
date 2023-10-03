<?php

namespace App\Repositories;

use App\Contracts\GalleryInterface;
use App\Models\Gallery;

class EloquentGalleryRepository implements GalleryInterface {
    protected $model;

    public function __construct(Gallery $model) {
        $this->model = $model;
    }

    public function getAlls() {
        return $this->model;
    }

    public function getById(string $id) {
        return $this->model->find($id);
    }

    public function create(array $data) {
        return $this->model->create($data);
    }
    public function delete(string $id) {
        $item = $this->getById($id);
        $item->delete();
    }
}
