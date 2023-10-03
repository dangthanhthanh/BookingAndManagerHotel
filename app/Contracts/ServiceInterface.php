<?php
// app/Contracts/ServiceInterface.php

namespace App\Contracts;

interface ServiceInterface {
    public function getAlls();
    public function getBySlug(string $slug);
    public function create(array $data);
    public function update(string $slug, array $data);
    public function delete(string $slug);
    public function forceDelete(string $slug);
    public function restore(string $slug);
    public function setStatus(string $slug);
}
