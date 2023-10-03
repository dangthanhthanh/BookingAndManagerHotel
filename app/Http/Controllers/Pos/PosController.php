<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\BaseModelController;
use Illuminate\Http\Request;

class PosController extends BaseModelController
{
    public function __construct(string $table)
    {
        parent::__construct($table);
    }
}
