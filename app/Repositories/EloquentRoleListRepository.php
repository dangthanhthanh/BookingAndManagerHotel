<?php

namespace App\Repositories;

use App\Contracts\RoleListInterface;
use App\Models\RoleList;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EloquentRoleListRepository implements RoleListInterface {
    protected $model;

    public function __construct(RoleList $model) {
        $this->model = $model;
    }

    public function getAlls() {
        return $this->model;
    }

    public function getRoleByStaffs(string $staffId) {
        return $this->model->where('staff_id', $staffId);
    }
    public function deletedByStaffs(string $staffId) {
        return $this->model->where('staff_id', $staffId)
                    ->delete();
    }
    public function create(string $staffId, string $roleId){
        return $this->model->create(
            [
                'staff_id' => $staffId,
                'role_id' => $roleId
            ]);
    }
    public function delete(string $staffId, string $roleId) {
        return $this->model->where('staff_id', $staffId)
                    ->where('role_id', $roleId)
                    ->delete();
    }
}
