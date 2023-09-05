<?php

namespace App\Interfaces;

interface RepositoryInterface
{
    public function findBySlug(string $slug);// not withTrasher
    public function findBySlugWithTrashed(string $slug);// has withTrasher
    public function getAll();// not withTrasher
    public function getAllWithTrashed();// hash withTrasher
    public function create(array $data);
    public function createCustomerBooking(array $data);
    public function updateBySlug(string $slug, array $data);// not withTrasher
    public function restoreBySlug(string $slug);// has withTrasher
    public function deleteBySlug(string $slug);// not withTrasher
    public function forceDeleteBySlug(string $slug);// hash withTrasher
    public function findCustomerByPhone(string $phone);
}