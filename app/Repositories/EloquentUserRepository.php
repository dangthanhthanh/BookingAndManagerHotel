<?php

namespace App\Repositories;

use App\Contracts\UserInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentUserRepository implements UserInterface {
    protected $model;

    public function __construct(User $model) {
        $this->model = $model;
    }

    public function getAlls() {
        return $this->model;
    }
    public function getByPhone(string $phone){
        return $this->model->where('phone',$phone)->firstOrFail();
    }

    public function getBySlug(string $slug) {
        return $this->model->where('slug', $slug)->firstOrFail();
    }
    public function getRoleBySlug(string $slug) {
        return $this->getBySlug($slug)->roleLists();
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
