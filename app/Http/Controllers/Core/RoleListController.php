<?php

namespace App\Http\Controllers\Core;

use App\Contracts\RoleListInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleListController extends Controller
{
    private $repository;
    public function __construct(RoleListInterface $repository) {
        $this->repository = $repository;
    }
    //
}
