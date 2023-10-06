<?php

namespace App\Http\Controllers\Core;

use App\Contracts\UserInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $repository;
    private $roleListController;
    private $imageController;
    public function __construct(UserInterface $repository, 
                                RoleListController $roleListController,
                                ImageController $imageController)
    {
        $this->repository = $repository;
        $this->roleListController = $roleListController;
        $this->imageController = $imageController;
    }
    private function getAccountHasPermision()
    {
        return $this->roleListController->getAlls()->pluck('staff_id')->toArray();
    }
    protected function getAllStaffs()
    {
        return $this->repository->getAlls()
            ->whereIn('users.id', $this->getAccountHasPermision());
    }
    protected function getAllCustomer()
    {
        return $this->repository->getAlls()
            ->whereNotIn('users.id', $this->getAccountHasPermision());
    }
    protected function getCustomerByPhone(string $phone)
    {
        if($customers = $this->repository->getByPhone($phone)){
            return response()->json([
                'is_user'=>true,
                'customers'=>$customers
            ]);
        }else{
            return response()->json([
                'is_user'=>false,
                'phone'=>$phone
            ]);
        }
    }
    protected function getBySlug(string $slug)
    {
        return $this->repository->getBySlug($slug);
    }
    protected function createResource(Request $request)
    {
        try {
            $data = $this->processRequestData($request);
            $user = $this->repository->create($data);
            if (!$user) {
                throw new \Exception('User creation failed.');
            }
            $this->createRoles($user->id, $data['roles'] ?? []);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('user account creation failed.');
        }
    }
    protected function updateResource(Request $request, string $slug)
    {
        try {
            $data = $this->processRequestData($request, $slug);
            if ($this->repository->update($slug, $data)) {
                throw new \Exception('User update failed.');
            }
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception('User update failed.');
        }
    }
    protected function processRequestData(Request $request, string $slug = null)
    {
        $data = ($slug !== null) 
            ? $this->validateUpdateRequest($request, $slug) 
            : $this->validateCreateRequest($request);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            $data['password'] = Hash::make('123456789');
        }
        if (!empty($data['image'])) {
            $data['avatar_id'] = $this->uploadImage($data['image']);
            unset($data['image']);
        }
        return $data;
    }
    public function delete(string $slug){
        $this->repository->delete($slug);
        return redirect()->back();
    }
    public function foceDelete(string $slug)
    {
       $this->repository->forceDelete($slug);
       return redirect()->back();
    }
    public function restore(string $slug)
    {
        $this->repository->restore($slug);
        return redirect()->back();
    }
    protected function setStatus(string $slug)
    {
        $bool = $this ->repository-> setStatus($slug);
        $rep = $bool ?  1.1 : 1.0;
        return response()->json(["rep"=>($rep)]);
    }
    protected function uploadImage($image)
    {
        return $this->imageController->uploadImage($image);
    }
    private function validateCreateRequest(Request $request)
    {
        return $request->validate([
            'user_name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|min:8|max:12|unique:users,phone',
            'address' => 'required|string',
            'gender' => 'required|string',
            'roles' => 'nullable',
            'image' => ['nullable', 'mimes:jpeg,png'],
        ]);
    }
    private function validateUpdateRequest(Request $request, string $slug)
    {
        return $request->validate([
            'user_name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$slug.',slug',
            'phone' => 'required|min:8|max:12|unique:users,phone,'.$slug.',slug',
            'address' => 'required|string',
            'gender' => 'required|string',
            'image' => ['nullable', 'mimes:jpeg,png'],
        ]);
    }
    protected function getRoleBySlug($userId)
    {
        return $this->roleListController->getRoleByStaffs($userId)//or use RoleListController
            ->pluck('role_id')
            ->toArray();
    }
    protected function updateRolesForResource(string $slug, array $newRole)
    {
        try {
            $userId = $this->getBySlug($slug)->id;
            $oldRole = $this->getRoleBySlug($userId);
            $deletedRole = array_diff($oldRole, $newRole);
            $createdRole = array_diff($newRole, $oldRole);
            
            $this->deleteRoles($userId, $deletedRole);
            $this->createRoles($userId, $createdRole);
            
            return true;
        } catch (\Exception $e) {
            throw new \Exception('Role update failed.');
        }
    }

    protected function deleteRoles(int $userId, array $roles)
    {
        foreach ($roles as $role) {
            if (!$this->roleListController->delete($userId, $role)) {
                throw new \Exception("Error deleting role: $role");
            }
        }
    }

    protected function createRoles(int $userId, array $roles)
    {
        foreach ($roles as $role) {
            if (!$this->roleListController->create($userId, $role)) {
                throw new \Exception("Error creating role: $role");
            }
        }
    }
}
