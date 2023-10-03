<?php

namespace App\Http\Controllers\Core;

use App\Contracts\ImageInterface;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{
    private $repository;

    public function __construct(ImageInterface $repository)
    {
        $this->repository = $repository;
    }

    public function uploadImage($image)
    {
        $fileName = $this->generateFileName($image);
        $this->moveImageToPublicPath($image, $fileName);
        $url = $this->generateImageUrl($fileName);

        $imageModel = $this->repository->create([
            'url' => $url,
        ]);

        return $imageModel->id;
    }

    private function generateFileName($file)
    {
        $originName = $file->getClientOriginalName();
        $fileName = pathinfo($originName, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();

        return $fileName . '_' . time() . '.' . $extension;
    }

    private function moveImageToPublicPath($image, $fileName)
    {
        $image->move(public_path('media'), $fileName);
    }

    private function generateImageUrl($fileName)
    {
        return asset('media/' . $fileName);
    }
}
