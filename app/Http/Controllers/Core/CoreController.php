<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\BaseModelController;
use App\Http\Controllers\Controller;

class CoreController extends Controller
{
    protected function uploadImage($image)
    {
        $baseModelController = new BaseModelController();
        return $baseModelController->uploadImage($image);
    }
}
