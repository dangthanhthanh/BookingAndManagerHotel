<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Account\CustomerController;
use App\Http\Controllers\Admin\Account\StaffController;
use App\Http\Controllers\Admin\Booking\BookingEventController;
use App\Http\Controllers\Admin\Booking\BookingFoodController;
use App\Http\Controllers\Admin\Booking\BookingRoomController;
use App\Http\Controllers\Admin\Booking\BookingServiceController;
use App\Http\Controllers\Admin\BookingRequestController;
use App\Http\Controllers\Admin\Category\BlogCategoryController;
use App\Http\Controllers\Admin\Category\FoodCategoryController;
use App\Http\Controllers\Admin\Category\PaymentMethodController;
use App\Http\Controllers\Admin\Category\PaymentStatusController;
use App\Http\Controllers\Admin\Category\RoleController;
use App\Http\Controllers\Admin\Category\RoomStatusController;
use App\Http\Controllers\Admin\Category\ServiceCategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\Product\BlogController;
use App\Http\Controllers\Admin\Product\FoodController;
use App\Http\Controllers\Admin\Product\RoomController;
use App\Http\Controllers\Admin\Product\ServiceController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\Product\EventController;
use App\Http\Controllers\Admin\Product\RoomCategoryController;
use App\Http\Controllers\Admin\ReviewController;

Route::prefix('/manager')
    ->middleware('manager')
    ->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('manager.dashboard');

     //account
    Route::prefix('/account')->group(function () {
    // Customer routes
        Route::prefix('/customer')->group(function () {
            //view
            Route::get('/', [CustomerController::class, 'index'])->name('customer.index');
            Route::get('/{slug}', [CustomerController::class, 'show'])->name('customer.show');
            //handle
            Route::post('/addToStaff/{slug}', [CustomerController::class, 'addToStaff'])->name('customer.addToStaff');
            Route::post('/setstatus/{slug}', [CustomerController::class, 'setStatus'])->name('customer.setstatus');
            Route::post('/restore/{slug}', [CustomerController::class, 'restore'])->name('customer.restore');
            Route::post('/delete/{slug}', [CustomerController::class, 'delete'])->name('customer.delete');
            //forceDelete handle
            Route::post('/forceDelete/{slug}', [CustomerController::class, 'forceDelete'])->name('customer.forceDelete');
        });

        // Staff routes
        Route::prefix('/staff')->group(function () {
            //view
            Route::get('/', [StaffController::class, 'index'])->name('staff.index');
            Route::get('/{slug}', [StaffController::class, 'show'])->name('staff.show');
            Route::get('/create', [StaffController::class, 'create'])->name('staff.create');
            //handle
            Route::post('/store', [StaffController::class, 'store'])->name('staff.store');
            Route::post('/update/role/{slug}', [StaffController::class, 'updateRole'])->name('staff.update.role');
            Route::post('/update/profile/{slug}', [StaffController::class, 'update'])->name('staff.update.profile');
            Route::post('/setStatus/{slug}', [StaffController::class, 'setStatus'])->name('staff.setstatus');
            Route::post('/delete/{slug}', [StaffController::class, 'delete'])->name('staff.delete');
            //forceDelete handle
            Route::post('forceDelete/{slug}', [StaffController::class, 'forceDelete'])->name('staff.forceDelete');
        });
    });

    Route::prefix('/product')->group(function () {
        
        Route::prefix('/blog')->group(function () {
            //view
            Route::get('/', [BlogController::class, 'index'])->name('blog.index');
            Route::get('/add', [BlogController::class, 'add'])->name('blog.add');
            Route::get('/edit/{slug}', [BlogController::class, 'edit'])->name('blog.edit');
            Route::get('/description/{slug}', [BlogController::class, 'description'])->name('blog.description');
            //handle
            Route::post('/store', [BlogController::class, 'store'])->name('blog.store');
            Route::post('/update/{slug}', [BlogController::class, 'update'])->name('blog.update');
            Route::post('/delete/{slug}', [BlogController::class, 'delete'])->name('blog.delete');
            Route::post('/setstatus/{slug}', [BlogController::class, 'setStatus'])->name('blog.setstatus');
            //forceDelete handle
            // Route::post('/forceDelete/{slug}', [BlogController::class, 'forceDelete'])->name('blog.forceDelete');
        });
    
        Route::prefix('/room')->group(function () {
            //view
            Route::get('/', [RoomController::class, 'index'])->name('room.index');
            Route::get('/edit/{slug}', [RoomController::class, 'edit'])->name('room.edit');
            Route::get('/add', [RoomController::class, 'add'])->name('room.add');
            Route::get('/description/{slug}', [RoomController::class, 'description'])->name('room.description');
            //handle
            Route::post('/store', [RoomController::class, 'store'])->name('room.store');
            Route::post('/update/{slug}', [RoomController::class, 'update'])->name('room.update');
            Route::post('/delete/{slug}', [RoomController::class, 'delete'])->name('room.delete');
            Route::post('/setstatus/{slug}', [RoomController::class, 'setstatus'])->name('room.setstatus');
            //forceDelete handle
            // Route::post('/forceDelete/{slug}', [RoomController::class, 'forceDelete'])->name('room.forceDelete');
        });

        Route::prefix('/service')->group(function () {
            //view
            Route::get('/', [ServiceController::class, 'index'])->name('service.index');
            Route::get('/edit/{slug}', [ServiceController::class, 'edit'])->name('service.edit');
            Route::get('/add', [ServiceController::class, 'add'])->name('service.add');
            Route::get('/description/{slug}', [ServiceController::class, 'description'])->name('service.description');
            //handle
            Route::post('/store', [ServiceController::class, 'store'])->name('service.store');
            Route::post('/update/{slug}', [ServiceController::class, 'update'])->name('service.update');
            Route::post('/delete/{slug}', [ServiceController::class, 'delete'])->name('service.delete');
            Route::post('/setstatus/{slug}', [ServiceController::class, 'setstatus'])->name('service.setstatus');
            //forceDelete handle
            // Route::post('/forceDelete/{slug}', [ServiceController::class, 'forceDelete'])->name('service.forceDelete');
        });

        Route::prefix('/event')->group(function () {
            //view
            Route::get('/', [EventController::class, 'index'])->name('event.index');
            Route::get('/edit/{slug}', [EventController::class, 'edit'])->name('event.edit');
            Route::get('/add', [EventController::class, 'add'])->name('event.add');
            Route::get('/description/{slug}', [EventController::class, 'description'])->name('event.description');
            //handle
            Route::post('/store', [EventController::class, 'store'])->name('event.store');
            Route::post('/update/{slug}', [EventController::class, 'update'])->name('event.update');
            Route::post('/delete/{slug}', [EventController::class, 'delete'])->name('event.delete');
            Route::post('/setstatus/{slug}', [EventController::class, 'setstatus'])->name('event.setstatus');
            //forceDelete handle
            // Route::post('/forceDelete/{slug}', [EventController::class, 'forceDelete'])->name('event.forceDelete');
        });

        Route::prefix('/food')->group(function () {
            //view
            Route::get('/', [FoodController::class, 'index'])->name('food.index');
            Route::get('/edit/{slug}', [FoodController::class, 'edit'])->name('food.edit');
            Route::get('/add', [FoodController::class, 'add'])->name('food.add');
            Route::get('/description/{slug}', [FoodController::class, 'description'])->name('food.description');
            //handle
            Route::post('/store', [FoodController::class, 'store'])->name('food.store');
            Route::post('/{slug}', [FoodController::class, 'update'])->name('food.update');
            Route::post('/delete/{slug}', [FoodController::class, 'delete'])->name('food.delete');
            Route::post('/setstatus/{slug}', [FoodController::class, 'setstatus'])->name('food.setstatus');
            //forceDelete handle
            // Route::post('/forceDelete/{slug}', [FoodController::class, 'forceDelete'])->name('food.forceDelete');
        });

    }); 

    Route::prefix('/review')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('review.index');
        Route::post('/delete/{slug}', [ReviewController::class, 'delete'])->name('review.delete');
        Route::post('/setstatus/{slug}', [ReviewController::class, 'setStatus'])->name('review.setstatus');
    });

    //telesale for customer contact 
    Route::prefix('/contact')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('contact.index');
        Route::post('/delete/{slug}', [ContactController::class, 'delete'])->name('contact.delete');
        Route::post('/advise/{slug}', [ContactController::class, 'advise'])->name('contact.advise');
        Route::post('/telesale/{slug}', [ContactController::class, 'telesale'])->name('booking.request.telesale');
    });

    //telesale for customer booking request 
    Route::prefix('/bookingRequest')->group(function () {
        Route::get('/', [BookingRequestController::class, 'index'])->name('booking.request.index');
        Route::post('/delete/{slug}', [BookingRequestController::class, 'delete'])->name('booking.request.delete');
        Route::post('/advise/{slug}', [BookingRequestController::class, 'advise'])->name('booking.request.advise');
        Route::post('/telesale/{slug}', [BookingRequestController::class, 'telesale'])->name('booking.request.telesale');
    });

    Route::prefix('/notify')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notify.index');
        Route::post('/delete/{id}', [NotificationController::class, 'delete'])->name('notify.delete');
        Route::get('/mail/custom', [NotificationController::class, 'customMail'])->name('notify.customMail');
        Route::post('/mail/sent', [NotificationController::class, 'sentMail'])->name('notify.sendMail');
    });
    
    Route::prefix('/gallery')->group(function () {
        Route::get('/', [GalleryController::class, 'index'])->name('gallery.index');
        Route::post('/store', [GalleryController::class, 'store'])->name('gallery.store');
        Route::post('/delete', [GalleryController::class, 'deleteForArrayID'])->name('gallery.delete');
    });

    Route::prefix('/order')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('order.index');
        Route::post('/', [OrderController::class, 'store'])->name('order.store');
        Route::get('/detail/{slug}', [OrderController::class, 'show'])->name('order.detail');
        Route::post('/{slug}', [OrderController::class, 'update'])->name('order.update');
        Route::post('/delete/{slug}', [OrderController::class, 'delete'])->name('order.delete');
        Route::post('/forceDelete/{slug}', [OrderController::class, 'forceDelete'])->name('order.forceDelete');
    });

    Route::prefix('/payment')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('payment.index');
        Route::post('/', [PaymentController::class, 'store'])->name('payment.store');
        Route::post('/{slug}', [PaymentController::class, 'update'])->name('payment.update');
        Route::post('/delete/{slug}', [PaymentController::class, 'delete'])->name('payment.delete');
        Route::post('/forceDelete/{slug}', [PaymentController::class, 'forceDelete'])->name('payment.forceDelete');
    });

   
    // booking
    Route::prefix('/booking')->group(function () {
        // Room routes
        Route::prefix('/room')->group(function () {
            Route::get('/', [BookingRoomController::class, 'index'])->name('booking.room.index');
            Route::post('/delete/{slug}', [BookingRoomController::class, 'delete'])->name('booking.room.delete');
            Route::post('/restore/{slug}', [BookingRoomController::class, 'restore'])->name('booking.room.restore');
            Route::post('/forceDelete/{slug}', [BookingRoomController::class, 'forceDelete'])->name('booking.room.forceDelete');
        });

        // Food routes
        Route::prefix('/food')->group(function () {
            Route::get('/', [BookingFoodController::class, 'index'])->name('booking.food.index');
            Route::post('/delete/{slug}', [BookingFoodController::class, 'delete'])->name('booking.food.delete');
            Route::post('/restore/{slug}', [BookingFoodController::class, 'restore'])->name('booking.food.restore');
            Route::post('/forceDelete/{slug}', [BookingFoodController::class, 'forceDelete'])->name('booking.food.forceDelete');
        });

        // Service routes
        Route::prefix('/service')->group(function () {
            Route::get('/', [BookingServiceController::class, 'index'])->name('booking.service.index');
            Route::post('/delete/{slug}', [BookingServiceController::class, 'delete'])->name('booking.service.delete');
            Route::post('/restore/{slug}', [BookingServiceController::class, 'restore'])->name('booking.service.restore');
            Route::post('/forceDelete/{slug}', [BookingServiceController::class, 'forceDelete'])->name('booking.service.forceDelete');
        });

        Route::prefix('/event')->group(function () {
            Route::get('/', [BookingEventController::class, 'index'])->name('booking.event.index');
            Route::post('/delete/{slug}', [BookingEventController::class, 'delete'])->name('booking.event.delete');
            Route::post('/restore/{slug}', [BookingEventController::class, 'restore'])->name('booking.event.restore');
            Route::post('/forceDelete/{slug}', [BookingEventController::class, 'forceDelete'])->name('booking.event.forceDelete');
        });
    });

    Route::prefix('/category')->group(function () {
        // Food category routes
        Route::prefix('/blog')->group(function () {
            Route::get('/', [BlogCategoryController::class, 'index'])->name('category.blog.index');
            Route::post('/', [BlogCategoryController::class, 'store'])->name('category.blog.store');
            Route::post('/delete/{slug}', [BlogCategoryController::class, 'delete'])->name('category.blog.delete');
        });

        Route::prefix('/food')->group(function () {
            Route::get('/', [FoodCategoryController::class, 'index'])->name('category.food.index');
            Route::post('/', [FoodCategoryController::class, 'store'])->name('category.food.store');
            Route::post('/delete/{slug}', [FoodCategoryController::class, 'delete'])->name('category.food.delete');
        });
    
        // Service category routes
        Route::prefix('/service')->group(function () {
            Route::get('/', [ServiceCategoryController::class, 'index'])->name('category.service.index');
            Route::post('/', [ServiceCategoryController::class, 'store'])->name('category.service.store');
            Route::post('/delete/{slug}', [ServiceCategoryController::class, 'delete'])->name('category.service.delete');
        });
    
        // Role category routes
        Route::prefix('/role')->group(function () {
            Route::get('/', [RoleController::class, 'index'])->name('category.role.index');
            Route::post('/', [RoleController::class, 'store'])->name('category.role.store');
            Route::post('/delete/{slug}', [RoleController::class, 'delete'])->name('category.role.delete');
        });
    
        // Room status category routes
        Route::prefix('/room/status')->group(function () {
            Route::get('/', [RoomStatusController::class, 'index'])->name('category.room.status.index');
            Route::post('/', [RoomStatusController::class, 'store'])->name('category.room.status.store');
            Route::post('/delete/{slug}', [RoomStatusController::class, 'delete'])->name('category.room.status.delete');
        });
    
        // Payment status category routes
        Route::prefix('/payment/status')->group(function () {
            Route::get('/', [PaymentStatusController::class, 'index'])->name('category.payment.status.index');
            Route::post('/', [PaymentStatusController::class, 'store'])->name('category.payment.status.store');
            Route::post('/delete/{slug}', [PaymentStatusController::class, 'delete'])->name('category.payment.status.delete');
        });
    
        // Payment method category routes
        Route::prefix('/payment/method')->group(function () {
            Route::get('/', [PaymentMethodController::class, 'index'])->name('category.payment.method.index');
            Route::post('/', [PaymentMethodController::class, 'store'])->name('category.payment.method.store');
            Route::post('/delete/{slug}', [PaymentMethodController::class, 'delete'])->name('category.payment.method.delete');
        });

        // Room category routes
        Route::prefix('/room')->group(function () {
            // view
            Route::get('/', [RoomCategoryController::class, 'index'])->name('category.room.index');
            Route::get('/edit/{slug}', [RoomCategoryController::class, 'edit'])->name('category.room.edit');
            Route::get('/add', [RoomCategoryController::class, 'add'])->name('category.room.add');
            Route::get('/description/{slug}', [RoomCategoryController::class, 'description'])->name('category.room.description');
            //handle
            Route::post('/setstatus/{slug}', [RoomCategoryController::class, 'setstatus'])->name('category.room.setstatus');
            Route::post('store/', [RoomCategoryController::class, 'store'])->name('category.room.store');
            Route::post('/{slug}', [RoomCategoryController::class, 'update'])->name('category.room.update');
            Route::post('/delete/{slug}', [RoomCategoryController::class, 'delete'])->name('category.room.delete');
            //forceDelete handle
            // Route::post('/forceDelete/{slug}', [RoomCategoryController::class, 'forceDelete'])->name('category.room.forceDelete');
        });
    
    });
});