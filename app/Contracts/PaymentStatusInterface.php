<?php
// app/Contracts/BlogInterface.php

namespace App\Contracts;

interface PaymentStatusInterface {
    public function getAlls();
    public function getBySlug(string $slug);
    public function getById(string $id);
    public function create(array $data);
    public function update(string $slug, array $data);
    public function delete(string $slug);
    public function forceDelete(string $slug);
    public function restore(string $slug);
}
