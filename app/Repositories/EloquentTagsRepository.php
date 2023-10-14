<?php

namespace App\Repositories;

use App\Contracts\TagsInterface;
use App\Models\Tags;

class EloquentTagsRepository implements TagsInterface {
    protected $model;
    public function __construct(Tags $model) {
        $this->model = $model;
    }
    public function getAlls() {
        return $this->model;
    }
    public function create(array $data) {
        return $this->model->create($data);
    }
    public function delete(string $id) {
        $item = $this->model->find($id)->delete();
    }
}
