<?php

namespace App\Providers;

use App\Models\BlogCategory;
use App\Models\FoodCategory;
use App\Models\PaymentMethod;
use App\Models\PaymentStatus;
use App\Models\Role;
use App\Models\RoomCategory;
use App\Models\ServiceCategory;
use App\Models\StatusContact;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $categoryArrays = [
            [
                'model' => StatusContact::class,
                'views' => [
                    // "admin.page.contact.index",
                    "admin.page.bookingrequest.advise",
                    // "admin.page.contact.advise",
                ],
                'variableName' => 'statuses'
            ],
            [
                'model' => PaymentMethod::class,
                'views' => [
                    "admin.page.payment.index",
                ],
                'variableName' => 'paymentMethod'
            ],
            [
                'model' => PaymentStatus::class,
                'views' => [
                    "admin.page.payment.index",
                    "admin.page.order.index",
                ],
                'variableName' => 'paymentStatus'
            ],
            [
                'model' => Role::class,
                'views' => [
                    "admin.page.account.customer.detail",
                    "admin.page.account.staff.detail",
                    "admin.page.account.staff.index",
                    "admin.page.account.staff.add",
                ],
                'variableName' => 'roles'
            ],
            [
                'model' => BlogCategory::class,
                'views' => [
                    "admin.page.product.blog.add",
                    "admin.page.product.blog.edit",
                    "client.page.blog",
                ],
                'variableName' => 'category'
            ],
            [
                'model' => RoomCategory::class,
                'views' => [
                    "admin.page.product.room.add",
                    "admin.page.product.room.edit",
                    "pos.page.room.index",
                    "client.component.bookingform",
                    "client.page.room",
                    "client.page.booking_room.counselors",
                ],
                'variableName' => 'category'
            ],
            [
                'model' => ServiceCategory::class,
                'views' => [
                    "admin.page.product.service.add",
                    "admin.page.product.service.edit",
                    "pos.page.service.index",
                    "client.page.service",
                ],
                'variableName' => 'category'
            ],
            [
                'model' => FoodCategory::class,
                'views' => [
                    "admin.page.product.food.add",
                    "admin.page.product.food.edit",
                    "pos.page.food.index",
                    "client.page.food",
                ],
                'variableName' => 'category'
            ],
        ];
    
        foreach ($categoryArrays as $categoryArray) {
            View::composer($categoryArray['views'], function ($view) use ($categoryArray) {
                $categories = $categoryArray['model']::orderBy('id', 'desc')->select('id', 'name', 'slug')->get();
                $view->with($categoryArray['variableName'], $categories);
            });
        }
    }
}
