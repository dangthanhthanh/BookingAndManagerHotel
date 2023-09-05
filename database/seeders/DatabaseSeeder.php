<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
use App\Models\Role;
use App\Models\RoleList;
use App\Models\Room;
use App\Models\RoomCategory;
use App\Models\RoomStatus;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\StatusContact;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Image::factory(20)->create();
        // Create Account Manager
        User::factory()->create([
            'user_name' => 'manager',
            'phone' => '01635763785',
            'email' => 'dangtanthanh12a2@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'), // password
            'avatar_id'  => 1
        ]);
        Role::factory()->create([
            "name"   =>"Manager",
        ]);
        RoleList::factory()->create([
            'staff_id' => 1,
            'role_id' => 1,
        ]);
        // Create Account guest for pos payment
        User::factory()->create([
            'user_name' => 'default guest',
            'phone' => substr(hash('sha256','default guest'),11, 11),
            'email' => 'dangtanthanh213213@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'), // password
            'avatar_id'  => 1
        ]);
        User::factory(50)->create();
        StatusContact::factory(10)->create();
        Review::factory(20)->create();
        Contact::factory(20)->create();
        NewsEmail::factory(20)->create();

        ServiceCategory::factory(10)->create();
        RoomCategory::factory(10)->create();
        FoodCategory::factory(10)->create();
        BlogCategory::factory(10)->create();
        Role::factory(10)->create();
        RoleList::factory(30)->create();
        PaymentStatus::factory(10)->create();
        PaymentMethod::factory(10)->create();
        RoomStatus::factory(10)->create();

        Blog::factory(20)->create();
        Gallery::factory(20)->create();
        Room::factory(20)->create();
        Food::factory(20)->create();
        Service::factory(20)->create();
        Order::factory(20)->create();
        BookingFood::factory(20)->create();
        BookingRoom::factory(20)->create();
        BookingService::factory(20)->create();
        BookingRequest::factory(20)->create();
        Payment::factory(20)->create();
    }
}
