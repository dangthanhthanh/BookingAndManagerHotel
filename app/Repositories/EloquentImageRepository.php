<?php

namespace App\Repositories;

use App\Contracts\ImageInterface;
use App\Models\Image;

class EloquentImageRepository implements ImageInterface {
    protected $model;

    public function __construct(Image $model) {
        $this->model = $model;
    }

    public function create(array $data) {
        return $this->model->create($data);
    }
}
