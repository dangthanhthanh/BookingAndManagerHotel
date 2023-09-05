<?php

namespace App\Repositories;

use App\Interfaces\ModelFactoryInterface;
use App\Interfaces\RepositoryInterface;
use App\Models\User;

class AdminRepository implements RepositoryInterface
{
    protected $model;

    public function __construct(ModelFactoryInterface $modelFactory, string $table)
    {
        $this->model = $modelFactory->createModel($table);
    }
    // not withTrasher
    public function findBySlug(string $slug)
    {
        return $this->model->where('slug', $slug)->firstOrFail();
    }
    // has withTrasher
    public function findBySlugWithTrashed(string $slug)
    {
        return $this->model->withTrashed()->where('slug', $slug)->firstOrFail();
    }
    // not withTrasher
    public function getAll()
    {
        return $this->model->all();
    }
    // has withTrasher
    public function getAllWithTrashed()
    {
        return $this->model->withTrashed()->all();
    }
    // not withTrasher
    public function create(array $data)
    {
        return $this->model->create($data);
    }
    // not withTrasher
    public function updateBySlug(string $slug, array $data)
    {
        $item = $this->findBySlug($slug);
        if ($item) {
            $item->update($data);
            return true;
        }
        return false;
    }
    // not withTrasher
    public function deleteBySlug(string $slug)
    {
        $item = $this->findBySlug($slug);
        if ($item) {
            return $item->delete();
        }
        return false;
    }
    // has withTrasher
    public function restoreBySlug(string $slug)
    {
        $item = $this->findBySlugWithTrashed($slug);
        if ($item) {
            return $item->restore();
        }
        return false;
    }
    // has withTrasher
    public function forceDeleteBySlug(string $slug)
    {
        $item = $this->findBySlugWithTrashed($slug);
        if ($item) {
            return $item->forceDelete();
        }
        return false;
    }
    public function findCustomerByPhone(string $phone)
    {
        $customer = User::where('phone', $phone)->first();
        return $customer;
    }
    public function createCustomerBooking(array $data){
        return User::create($data);
    }
}