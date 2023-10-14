<?php

namespace App\Repositories;

use App\Contracts\RoleInterface;
use App\Models\Role;

class EloquentRoleRepository implements RoleInterface {
    protected $model;

    public function __construct(Role $model) {
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
    public function update(string $id,array $data) {
        return $this->getById($id)->update($data);
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
