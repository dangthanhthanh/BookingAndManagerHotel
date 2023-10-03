<?php

namespace App\Http\Controllers\Core;

use App\Contracts\UserInterface;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    private $repository;
    public function __construct(UserInterface $repository) {
        $this->repository = $repository;
    } 
    //
}
