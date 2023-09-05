<?php

namespace App\Http\Controllers\Admin\Account;

use App\Models\Role;
use App\Models\RoleList;
use Illuminate\Http\Request;

class CustomerController extends AccountController
{
    public function __construct()
    {
        parent::__construct('customer');
    }

    public function index(Request $request)
    {   
        $query = $this->getModel()->withTrashed()
            ->leftJoin('images', 'users.avatar_id', '=', 'images.id')
            ->select('users.*', 'images.url as avatar_url');
        $datas = $query->when($request->has('searchByName'), function ($query) use ($request) {
                $query->where('users.user_name', 'LIKE', '%' . $request->searchByName . '%');
            })
            ->when($request->has('sortType') && $request->sortType === 'desc', function ($query) use ($request) {
                $query->orderByDesc($request->input('sortBy'));
            })
            ->when($request->has('sortType') && $request->sortType === 'asc', function ($query) use ($request) {
                $query->orderBy($request->input('sortBy'));
            })
            ->paginate(10);
        return view('admin.page.account.customer.index', compact('datas'));
    }

    public function show(string $slug)
    {
        $data = $this->adminRepository->findBySlugWithTrashed($slug);
        return view('admin.page.account.customer.detail', compact('data'));
    }

    public function addToStaff(Request $request, string $slug)
    {
        $data = $request->validate(['roles' => 'required']);
        $customer_id = $this->adminRepository->findBySlugWithTrashed($slug)->id;
        foreach($data['roles'] as $item){
            RoleList::create([
                'staff_id' => $customer_id,
                'role_id' => $item,
            ]);
        }
        return redirect()->route("customer.index")->with('messenger',1);
    }
}
