<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\BaseModelController;

class PosController extends BaseModelController
{
    public function __construct(string $table)
    {
        // $this->middleware("admin.or.manager");
        parent::__construct($table);
    }
}
