<?php
// app/Contracts/RoomInterface.php

namespace App\Contracts;

interface RoomInterface {
    public function getAlls();
    public function getBySlug(string $slug);
    public function getById($id);
    public function create(array $data);
    public function update(string $slug, array $data);
    public function delete(string $slug);
    public function forceDelete(string $slug);
    public function restore(string $slug);
    public function setStatus(string $slug);
}
