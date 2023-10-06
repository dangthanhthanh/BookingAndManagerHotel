<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core\BlogController;
use App\Http\Controllers\Core\FoodController;
use App\Http\Controllers\Core\GalleryController;
use App\Http\Controllers\Core\ReviewController;
use App\Http\Controllers\Core\RoomCategoryController;
use App\Http\Controllers\Core\ServiceController;

class HomeController extends Controller
{
    private $roomCategoryController;
    private $reviewController;
    private $blogController;
    private $foodController;
    private $serviceController;
    private $galleryController;
    public function __construct(RoomCategoryController $roomCategoryController,
                                ReviewController $reviewController,
                                BlogController $blogController,
                                FoodController $foodController,
                                ServiceController $serviceController,
                                GalleryController $galleryController)
    {
        $this->roomCategoryController = $roomCategoryController;
        $this->reviewController = $reviewController;
        $this->blogController = $blogController;
        $this->foodController = $foodController;
        $this->serviceController = $serviceController;
        $this->galleryController = $galleryController;
    }
    public function index(){
        $reviews = $this->reviewController->getAlls()
            ->orderByDesc('rate')
            ->where('rate', '>=', 3)
            ->where('active', true)
            ->limit(20)
            ->get();

        $blogs = $this->roomCategoryController->getAlls()
            ->orderByDesc('created_at')
            ->where('active', true)
            ->limit(10)
            ->get();

        $roomCategorys = $this->blogController->getAlls()
            ->orderByDesc('id')
            ->where('active', true)
            ->get();

        $foods = $this->foodController->getAlls()
            ->orderByDesc('created_at')
            ->where('active', true)
            ->limit(10)
            ->get();

        $services = $this->serviceController->getAlls()
            ->orderByDesc('created_at')
            ->where('active', true)
            ->limit(10)
            ->get();

        $gallerys = $this->galleryController->getAlls()
            ->orderByDesc('id')
            ->limit(20)
            ->get();

        return view("home",compact("gallerys","roomCategorys","reviews","blogs",'gallerys','foods','services'));
    }
}
