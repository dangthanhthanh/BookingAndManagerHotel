<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\BaseModelController;

class ClientController extends BaseModelController
{
    public function __construct(string $table)
    {
        parent::__construct($table);
    }
}
