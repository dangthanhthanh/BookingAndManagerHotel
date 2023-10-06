<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;

class CoreController extends Controller
{
    protected $imageController;
    public function __construct(ImageController $imageController) {
        $this -> imageController = $imageController;
    }
    protected function uploadImage($image)
    {
        return $this->imageController->uploadImage($image);
    }
}
