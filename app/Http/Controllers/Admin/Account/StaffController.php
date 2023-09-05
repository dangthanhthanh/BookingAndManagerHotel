<?php

namespace App\Http\Controllers\Admin\Account;

use App\Models\RoleList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends AccountController
{
    public function __construct()
    {
        parent::__construct('staff');
    }

    public function index(Request $request)
    {
        $query = $this->getModel()->withTrashed()
            ->leftJoin('images', 'users.avatar_id', '=', 'images.id')
            ->select('users.*', 'images.url as avatar_url');
        $datas = $query->when($request->has('searchByName'), function ($query) use ($request) {
                $query->where('users.user_name', 'LIKE', '%' . $request->searchByName . '%');
            })
            ->when($request->has('role'), function ($query) use ($request) {
                $query->join('role_lists','users.id','=','role_lists.staff_id')
                    ->join('roles','role_lists.role_id','=','roles.id')
                    ->where('roles.slug',$request->role);
            })
            ->when($request->has('sortType') && $request->sortType === 'desc', function ($query) use ($request) {
                $query->orderByDesc($request->input('sortBy'));
            })
            ->when($request->has('sortType') && $request->sortType === 'asc', function ($query) use ($request) {
                $query->orderBy($request->input('sortBy'));
            })
            ->paginate(10);
        return view('admin.page.account.staff.index', compact('datas'));
    }

    public function create()
    {
        return view("admin.page.account.staff.add");
    }

    public function store(Request $request)
    {
        $data = $this->validateCreateStaffRequest($request);
        //set image_id
        if(!empty($data["image"])){
            $data['avatar_id'] = $this->uploadImage($data["image"]) ?? '1';
            unset($data['image']);
        }
        //default password(123456789);
        $data['password'] = Hash::make('123456789');
        $bool = $this->adminRepository->create($data);
        //add role for staff
        if ($bool && !empty($data["roles"])){
            $this -> addNewRole([], $data['roles'], $bool->id);
        }
        return redirect()->route("staff.index")->with('messenger', $bool ? 1 : 0);
    }

    private function validateCreateStaffRequest(Request $request)
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

    public function show(string $slug)
    {
        $data = $this->adminRepository->findBySlugWithTrashed($slug);
        return view('admin.page.account.staff.detail', compact('data'));
    }

    public function updateRole(Request $request, string $slug)
    {
        $datas = $request->validate(['roles' => 'required'])['roles'];
        $userId = $this->adminRepository->findBySlug($slug)->id;
        $roleForUser = $this->getRoleListTable()->getModel()->where('staff_id',$userId)->pluck('role_id')->toArray();
        $this->addNewRole( $roleForUser , $datas, $userId);
        $this->deleteOldRole( $roleForUser , $datas, $userId);
        return redirect()->back()->with('messenger', 1);
    }

    private function getRoleListTable(){
        return $this->getModelWithBaseModelController('role_list');
    }

    private function addNewRole(array $roleForUser = [] ,array $datas, string $userId){
        foreach ($datas as $dataId) {
            if(!(in_array($dataId, $roleForUser))){
                $data=[
                    'staff_id' => $userId,
                    'role_id' => $dataId,
                ];
                $this->getRoleListTable()->adminRepository->create($data);
            }
        };
    }

    private function deleteOldRole(array $roleForUser ,array $datas, string $userId){
        foreach ($roleForUser as $roleId) {
            if(!(in_array($roleId, $datas))){
                $data=[
                    'staff_id' => $userId,
                    'role_id' => $roleId,
                ];
                $this->getRoleListTable()->getModel()->where($data)->delete();
            }
        }
    }
    public function update(Request $request, string $slug)
    {
        $data = $this->validateUpdateStaffRequest($request, $slug);
        $data['user_name'] = ucfirst($data['user_name']);
        $data['email'] = ucfirst($data['email']);
        $data['phone'] = ucfirst($data['phone']);
        if(!empty($data["image"])){
            $data['avatar_id'] = $this->uploadImage($data["image"]) ?? '1';
            unset($data['image']);
        }
        $bool = $this->adminRepository->updateBySlug($slug, $data);
        if($bool){
            return redirect()->route("staff.index")->with('messenger', 1);
        }
        return redirect()->back()->with('messenger', 0);
    }

    private function validateUpdateStaffRequest(Request $request, string $slug)
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
    
}
