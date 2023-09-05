<?php

namespace App\Providers;

use App\Models\RoomCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ClientServiceProvider extends ServiceProvider
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
        $arrayRoomTypeView = [
            "client.component.bookingform",
            "client.page.booking",
            'client.page.bookingoneroom',
        ];
        View::composer($arrayRoomTypeView, function ($view) {
            $roomCategory = RoomCategory::orderBy('id', 'desc')->select('id','name')->get();
            $view->with('roomCategory', $roomCategory);
        });
    }
}
