<?php
namespace App\Contracts;

interface BookingEventInterface {
    public function getAlls();
    public function getBySlug(string $slug);
    public function getById(string $id);
    public function create(array $data);
    public function delete(string $slug);
}
