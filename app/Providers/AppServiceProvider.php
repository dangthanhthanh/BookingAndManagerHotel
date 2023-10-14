<?php

namespace App\Providers;

use App\Contracts\BlogCategoryInterface;
use App\Contracts\BlogInterface;
use App\Contracts\BookingEventInterface;
use App\Contracts\BookingFoodInterface;
use App\Contracts\BookingRequestInterface;
use App\Contracts\BookingRoomInterface;
use App\Contracts\BookingServiceInterface;
use App\Contracts\ContactInterface;
use App\Contracts\EventInterface;
use App\Contracts\FoodCategoryInterface;
use App\Contracts\FoodInterface;
use App\Contracts\GalleryInterface;
use App\Contracts\ImageInterface;
use App\Contracts\NewsEmailInterface;
use App\Contracts\OrderInterface;
use App\Contracts\PaymentInterface;
use App\Contracts\PaymentMethodInterface;
use App\Contracts\PaymentStatusInterface;
use App\Contracts\ReviewInterface;
use App\Contracts\RoleInterface;
use App\Contracts\RoleListInterface;
use App\Contracts\RoomCategoryInterface;
use App\Contracts\RoomInterface;
use App\Contracts\RoomStatusInterface;
use App\Contracts\ServiceCategoryInterface;
use App\Contracts\ServiceInterface;
use App\Contracts\StatusContactInterface;
use App\Contracts\UserInterface;
use App\Factories\ModelFactory;
use App\Interfaces\ModelFactoryInterface;
use App\Interfaces\RepositoryInterface;
use App\Repositories\AdminRepository;
use App\Repositories\EloquentBlogCategoryRepository;
use App\Repositories\EloquentBlogRepository;
use App\Repositories\EloquentBookingEventRepository;
use App\Repositories\EloquentBookingFoodRepository;
use App\Repositories\EloquentBookingRequestRepository;
use App\Repositories\EloquentBookingRoomRepository;
use App\Repositories\EloquentBookingServiceRepository;
use App\Repositories\EloquentContactRepository;
use App\Repositories\EloquentEventRepository;
use App\Repositories\EloquentFoodCategoryRepository;
use App\Repositories\EloquentFoodRepository;
use App\Repositories\EloquentGalleryRepository;
use App\Repositories\EloquentImageRepository;
use App\Repositories\EloquentNewsEmailRepository;
use App\Repositories\EloquentOrderRepository;
use App\Repositories\EloquentPaymentMethodRepository;
use App\Repositories\EloquentPaymentRepository;
use App\Repositories\EloquentPaymentStatusRepository;
use App\Repositories\EloquentReviewRepository;
use App\Repositories\EloquentRoleListRepository;
use App\Repositories\EloquentRoleRepository;
use App\Repositories\EloquentRoomCategoryRepository;
use App\Repositories\EloquentRoomRepository;
use App\Repositories\EloquentRoomStatusRepository;
use App\Repositories\EloquentServiceCategoryRepository;
use App\Repositories\EloquentServiceRepository;
use App\Repositories\EloquentStatusContactRepository;
use App\Repositories\EloquentUserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ModelFactoryInterface::class,
            ModelFactory::class);
        $this->app->bind(
            RepositoryInterface::class,
            AdminRepository::class);

        // post
        $this->app->bind(
            BlogInterface::class,
            EloquentBlogRepository::class
        );
        $this->app->bind(
            RoomInterface::class,
            EloquentRoomRepository::class
        );
        $this->app->bind(
            FoodInterface::class,
            EloquentFoodRepository::class
        );
        $this->app->bind(
            ServiceInterface::class,
            EloquentServiceRepository::class
        );
        // category
        $this->app->bind(
            RoomCategoryInterface::class,
            EloquentRoomCategoryRepository::class
        );
        $this->app->bind(
            BlogCategoryInterface::class,
            EloquentBlogCategoryRepository::class
        );
        $this->app->bind(
            FoodCategoryInterface::class,
            EloquentFoodCategoryRepository::class
        );
        $this->app->bind(
            ServiceCategoryInterface::class,
            EloquentServiceCategoryRepository::class
        );
        // booking
        $this->app->bind(
            BookingFoodInterface::class,
            EloquentBookingFoodRepository::class
        );
        $this->app->bind(
            BookingRoomInterface::class,
            EloquentBookingRoomRepository::class
        );
        $this->app->bind(
            BookingServiceInterface::class,
            EloquentBookingServiceRepository::class
        );
        $this->app->bind(
            BookingRequestInterface::class,
            EloquentBookingRequestRepository::class
        );
        //.. payment
        $this->app->bind(
            PaymentInterface::class,
            EloquentPaymentRepository::class
        );
        $this->app->bind(
            PaymentStatusInterface::class,
            EloquentPaymentStatusRepository::class
        );
        $this->app->bind(
            PaymentMethodInterface::class,
            EloquentPaymentMethodRepository::class
        );
        $this->app->bind(
            OrderInterface::class,
            EloquentOrderRepository::class
        );
        // .. user
        $this->app->bind(
            UserInterface::class,
            EloquentUserRepository::class
        );
        $this->app->bind(
            RoleInterface::class,
            EloquentRoleRepository::class
        );
        $this->app->bind(
            RoleListInterface::class,
            EloquentRoleListRepository::class
        );
        // .. orther
        $this->app->bind(
            ContactInterface::class,
            EloquentContactRepository::class
        );
        $this->app->bind(
            StatusContactInterface::class,
            EloquentStatusContactRepository::class
        );
        $this->app->bind(
            ReviewInterface::class,
            EloquentReviewRepository::class
        );
        $this->app->bind(
            NewsEmailInterface::class,
            EloquentNewsEmailRepository::class
        );
        $this->app->bind(
            ImageInterface::class,
            EloquentImageRepository::class
        );
        $this->app->bind(
            GalleryInterface::class,
            EloquentGalleryRepository::class
        );
        $this->app->bind(
            RoomStatusInterface::class,
            EloquentRoomStatusRepository::class
        );
        $this->app->bind(
            EventInterface::class,
            EloquentEventRepository::class
        );
        $this->app->bind(
            BookingEventInterface::class,
            EloquentBookingEventRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
