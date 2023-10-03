<?php
// app/Contracts/BlogInterface.php

namespace App\Contracts;

interface GalleryInterface {
    public function getAlls();
    public function getById(string $id);
    public function create(array $data);
    public function delete(string $slug);
}
