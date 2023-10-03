<?php

namespace App\Repositories;

use App\Contracts\ContactInterface;
use App\Models\Contact;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentContactRepository implements ContactInterface {
    protected $model;

    public function __construct(Contact $model) {
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

    public function update(string $slug, array $data) {
        $item = $this->getById($slug);
        $item->update($data);
        return $item;
    }

    public function delete(string $slug) {
        $item = $this->getById($slug);
        $item->delete();
    }
}
