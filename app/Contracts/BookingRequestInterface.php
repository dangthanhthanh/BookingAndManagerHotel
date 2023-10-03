<?php
// app/Contracts/BlogInterface.php

namespace App\Contracts;

interface BookingRequestInterface {
    public function getAlls();
    public function getBySlug(string $slug);
    public function create(array $data);
    public function update(string $slug, array $data);
    public function delete(string $slug);
}
