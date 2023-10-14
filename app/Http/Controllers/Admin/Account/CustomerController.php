<?php

namespace App\Http\Controllers\Admin\Account;

use App\Http\Controllers\Core\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends UserController
{
    public function index(Request $request)
    {   
        $query = $this->getAllCustomer()
            ->leftJoin('images', 'users.avatar_id', '=', 'images.id')
            ->select('users.*', 'images.url as avatar_url')
            ->when($request->has('searchByName'), function ($query) use ($request) {
                $query->where('users.user_name', 'LIKE', '%' . $request->searchByName . '%');
            })
            ->when($request->has('sortType') && $request->sortType === 'desc', function ($query) use ($request) {
                $query->orderByDesc($request->input('sortBy'));
            })
            ->when($request->has('sortType') && $request->sortType === 'asc', function ($query) use ($request) {
                $query->orderBy($request->input('sortBy'));
            });
            $datas = $query->paginate(10);
        return view('admin.page.account.customer.index', compact('datas'));
    }

    public function show(string $slug)
    {
        $data = $this->getBySlug($slug);
        return view('admin.page.account.customer.detail', compact('data'));
    }

    public function addToStaff(Request $request, string $slug)
    {
        $data = $request->validate(['roles' => 'required']);
        foreach($data['roles'] as $item){
            DB::transaction(function() use($slug, $item){
                $this->createdPermistion($slug,$item);
            },2);
        }
        return redirect()->route("customer.index")->with('messenger',1);
    }
}
