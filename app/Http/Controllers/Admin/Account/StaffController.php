<?php

namespace App\Http\Controllers\Admin\Account;

use App\Http\Controllers\Core\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StaffController extends UserController
{
    public function index(Request $request)
    {
        $query = $this->getAllStaffs()
            ->leftJoin('images', 'users.avatar_id', '=', 'images.id')
            ->select('users.*', 'images.url as avatar_url')
            ->when($request->has('searchByName'), function ($query) use ($request) {
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
            });
            $datas = $query->paginate(10);
        return view('admin.page.account.staff.index', compact('datas'));
    }

    public function create()
    {
        return view("admin.page.account.staff.add");
    }

    public function store(Request $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $this->createResource($request);
            });
            return redirect()->route("staff.index")->with('messenger', true);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('messenger', 0);
        }
    }
    public function show(string $slug)
    {
        $data = $this->getBySlug($slug);
        return view('admin.page.account.staff.detail', compact('data'));
    }

    public function updateRole(Request $request, string $slug)
    {
        try {
            $this->updateRolesForResource(
                $slug,
                $request->validate(['roles' => 'required'])['roles']
            );
            return redirect()->back()->with('messenger', 1);
        } catch (\Exception $e) {
            return redirect()->back()->with('messenger', 0);
        }
    }

    public function update(Request $request, string $slug)
    {
        try {
            $this->updateResource($request, $slug);
            return redirect()->route("staff.index")->with('messenger', 1);
        } catch (\Exception $e) {
            return redirect()->back()->with('messenger', 0);
        }
    }
}
