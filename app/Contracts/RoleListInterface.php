<?php
namespace App\Contracts;

interface RoleListInterface {
    public function getAlls();
    public function getRoleByStaffs(string $staffId);
    public function deletedByStaffs(string $staffId);
    public function create(string $staffId, string $roleId);
    public function delete(string $staffId, string $roleId);
}
