<?php

namespace App\Http\Controllers\Core;

use App\Contracts\ReviewInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    private $repository;
    public function __construct(ReviewInterface $repository)
    {
        $this->repository = $repository;
    } 
    public function getAlls(){
        return $this->repository->getAlls();
    }
    public function create(Request $request)
    {
        $bool = $this->repository->create($this->validateRequest($request));
        return redirect()->back()->with('messenger', $bool ? 1 : 0);
    }
    public function update(string $slug, Request $request)
    {
        $bool = $this->repository->update($slug, $this->validateRequest($request));
        return redirect()->back()->with('messenger', $bool ? 1 : 0);
    }
    private function validateRequest($request)
    {
        dd('chua xong');
        return $request->validate(
            [
                'name' => 'required|string'
            ]
        );
    }
    public function delete(string $slug)
    {
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
}
