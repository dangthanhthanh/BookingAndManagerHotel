<?php

namespace App\Http\Controllers\Core;

use App\Contracts\RoleListInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleListController extends Controller
{
    private $repository;
    public function __construct(RoleListInterface $repository) {
        $this->repository = $repository;
    }
    public function getAlls(){
        return $this->repository->getAlls();
    }
    public function getRoleByStaffs(string $staffId)
    {
        return $this->repository->getRoleByStaffs($staffId);
    }
    public function deletedAllRole(string $staffId)
    {
        return $this->repository->deletedByStaffs($staffId);
    }
    public function create(string $staffId, string $roleId)
    {
        return $this->repository->create($staffId, $roleId);
    }
    public function delete(string $staffId, string $roleId)
    {
        return $this->repository->delete($staffId, $roleId);
    }
}
