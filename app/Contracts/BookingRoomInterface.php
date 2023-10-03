<?php
// app/Contracts/BlogInterface.php

namespace App\Contracts;

interface BookingRoomInterface {
    public function getAlls();
    public function getBySlug(string $slug);
    public function getById(string $id);
    public function create(array $data);
    public function delete(string $slug);
}
