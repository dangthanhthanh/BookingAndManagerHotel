<?php

namespace App\Factories;

use App\Interfaces\ModelFactoryInterface;
use App\Models\User;
use App\Models\Role;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BookingFood;
use App\Models\BookingRequest;
use App\Models\BookingRoom;
use App\Models\BookingService;
use App\Models\Contact;
use App\Models\Food;
use App\Models\FoodCategory;
use App\Models\Gallery;
use App\Models\Image;
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
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\StatusContact;

class ModelFactory implements ModelFactoryInterface
{
    protected $map = [
        'customer' => User::class,
        'staff' => User::class,
        'role'=>Role::class,
        'role_list'=>RoleList::class,

        'blog' => Blog::class,
        'blog_category' => BlogCategory::class,

        'booking_request'=>BookingRequest::class,
        'status_contact'=>StatusContact::class,

        'food' => Food::class,
        'food_category' => FoodCategory::class,
        'booking_food'=>BookingFood::class,

        'service'=>Service::class,
        'service_category'=>ServiceCategory::class,
        'booking_service'=>BookingService::class,

        'room'=>Room::class,
        'room_status'=>RoomStatus::class,
        'room_category'=>RoomCategory::class,
        'booking_room'=>BookingRoom::class,

        'order'=>Order::class,
        'payment'=>Payment::class,
        'payment_status'=>PaymentStatus::class,
        'payment_method'=>PaymentMethod::class,

        'gallery'=>Gallery::class,
        'contact'=>Contact::class,
        'image'=>Image::class,
        'review'=>Review::class,
        'news_email'=>NewsEmail::class,
    ];

    public function createModel(string $table)
    {
        if (isset($this->map[$table])) {
            $modelClass = $this->map[$table];
            return app($modelClass);
        } else {
            // abort(404);
            throw new \InvalidArgumentException("Model not found for table: $table");
        }
    }
}