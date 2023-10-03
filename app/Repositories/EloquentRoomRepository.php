<?php

namespace App\Repositories;

use App\Contracts\RoomInterface;
use App\Models\Room;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class EloquentRoomRepository implements RoomInterface {
    protected $model;

    public function __construct(Room $model) {
        $this->model = $model;
    }

    public function getAlls() {
        return $this->model;
    }

    public function getBySlug(string $slug) {
        return $this->model->where('slug', $slug)->firstOrFail();
    }

    public function getById(string $id) {
        Log::info('room is id = '.$id);
        return $this->model->find($id);
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
