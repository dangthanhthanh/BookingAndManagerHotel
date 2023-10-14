<?php
// app/Contracts/BlogInterface.php

namespace App\Contracts;

interface TagsInterface {
    public function getAlls();
    public function create(array $data);
    public function delete(string $slug);
}
