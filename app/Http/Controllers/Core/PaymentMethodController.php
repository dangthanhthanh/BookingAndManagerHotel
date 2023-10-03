<?php

namespace App\Http\Controllers\Core;

use App\Contracts\PaymentMethodInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    private $repository;
    public function __construct(PaymentMethodInterface $repository) {
        $this->repository = $repository;
    } 
    protected function getAlls(){
        return $this->repository->getAlls();
    }
    public function create(Request $request)
    {
        $bool = $this->repository->create($this->validateRequest($request));
        return redirect()->back()->with('messenger', $bool ? 1 : 0);
    }
    public function update(string $id, Request $request)
    {
        $bool = $this->repository->update($id, $this->validateRequest($request));
        return redirect()->back()->with('messenger', $bool ? 1 : 0);
    }
    private function validateRequest($request){
        return $request->validate(['name' => 'required|string']);
    }
    public function delete(string $slug){
        $this->repository->delete($slug);
        return redirect()->back();
    }
    public function foceDelete(string $slug){
        $this->repository->forceDelete($slug);
        return redirect()->back();
    }
    public function restore(string $slug){
        $this->repository->restore($slug);
        return redirect()->back();
    }
}
