<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseModelController;
use Illuminate\Http\Request;

class AdminController extends BaseModelController
{
    public function __construct(string $table)
    {
        parent::__construct($table);
    }
    protected function sortByWithType($query ,Request $request){
        return $query->when($request->has('sortType') && $request->sortType === 'desc', function ($query) use ($request) {
            $query->orderByDesc($request->input('sortBy'));
        })
        ->when($request->has('sortType') && $request->sortType === 'asc', function ($query) use ($request) {
            $query->orderBy($request->input('sortBy'));
        });
    }

    protected function forceDelete(string $slug)
    {
        $bool = $this->adminRepository->forceDeleteBySlug($slug);
        return redirect()->back()->with('messenger',$bool ? 1 : 0);
    }
    protected function delete(string $slug)
    {
        $bool = $this->adminRepository->deleteBySlug($slug);
        return redirect()->back()->with('messenger', $bool ? 1 : 0);
    }
    protected function restore(string $slug)
    {
        $bool = $this->adminRepository->restoreBySlug($slug);
        return redirect()->back()->with('messenger', $bool ? 1 : 0);
    }   
    // setStatus for product item
    protected function setStatus(string $slug)
    {   
        $item = $this->adminRepository->findBySlug($slug);
        $bool=$item->update(["active"=>!$item->active]);
        $rep = $bool ?  1.1 : 1.0;
        return response()->json(["rep"=>($rep)]);
    }
    
}
