<?php

namespace App\Http\Controllers\Admin\Account;

use App\Http\Controllers\Admin\AdminController;

class AccountController extends AdminController
{
    public function __construct(string $table)
    {
        parent::__construct($table);
    }
}
