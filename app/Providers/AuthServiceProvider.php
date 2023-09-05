<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BookingFood;
use App\Models\BookingRoom;
use App\Models\BookingService;
use App\Models\Contact;
use App\Models\Food;
use App\Models\FoodCategory;
use App\Models\Gallery;
use App\Models\NewsEmail;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\PaymentStatus;
use App\Models\Review;
use App\Models\RoleList;
use App\Models\Room;
use App\Models\RoomCategory;
use App\Models\RoomStatus;
use App\Models\ServiceCategory;
use App\Models\User;
use App\Policies\BlogCategoryPolicy;
use App\Policies\BlogPolicy;
use App\Policies\BookingFoodPolicy;
use App\Policies\BookingServicePolicy;
use App\Policies\ContactPolicy;
use App\Policies\FoodCategoryPolicy;
use App\Policies\FoodPolicy;
use App\Policies\GalleryPolicy;
use App\Policies\HotelPolicy;
use App\Policies\NewsEmailPolicy;
use App\Policies\OrderPolicy;
use App\Policies\PaymentMethodPolicy;
use App\Policies\PaymentPolicy;
use App\Policies\PaymentStatusPolicy;
use App\Policies\ReviewPolicy;
use App\Policies\RoleListPolicy;
use App\Policies\RolePolicy;
use App\Policies\RoomCategoryPolicy;
use App\Policies\RoomPolicy;
use App\Policies\RoomStatusPolicy;
use App\Policies\ServiceCategoryPolicy;
use App\Policies\ServicePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Blog::class => BlogPolicy::class,
        BlogCategory::class => BlogCategoryPolicy::class,
        BookingFood::class => BookingFoodPolicy::class,
        BookingRoom::class => BookingFoodPolicy::class,
        BookingService::class => BookingServicePolicy::class,
        Contact::class => ContactPolicy::class,
        Food::class => FoodPolicy::class,
        FoodCategory::class => FoodCategoryPolicy::class,
        Gallery::class => GalleryPolicy::class,
        Hotel::class => HotelPolicy::class,
        NewsEmail::class => NewsEmailPolicy::class,
        Order::class => OrderPolicy::class,
        Payment::class => PaymentPolicy::class,
        PaymentMethod::class => PaymentMethodPolicy::class,
        PaymentStatus::class => PaymentStatusPolicy::class,
        Review::class => ReviewPolicy::class,
        Role::class => RolePolicy::class,
        RoleList::class => RoleListPolicy::class,
        Room::class => RoomPolicy::class,
        RoomCategory::class => RoomCategoryPolicy::class,
        RoomStatus::class => RoomStatusPolicy::class,
        Service::class => ServicePolicy::class,
        ServiceCategory::class => ServiceCategoryPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
