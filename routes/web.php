<?php

use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GuestBookingController;
use App\Http\Controllers\GuestPageController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\BoardingHouseController;
use App\Models\BoardingHouse;
use App\Models\Room;
use App\Models\Guest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerificationController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $stats = [
        'roomCount' => Room::count(),
        'guestCount' => Guest::count(),
    ];

    $availableRooms = Room::where('status', 'available')->count();

    $roomTypes = [
        [
            'name' => 'Deluxe Room',
            'description' => 'Spacious room with city view',
            'price' => Room::where('capacity', 2)->value('price_per_night') ?? 100.00,
            'image' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
        ],
        [
            'name' => 'Premium Suite',
            'description' => 'Luxury suite with panoramic view',
            'price' => Room::where('capacity', 3)->value('price_per_night') ?? 150.00,
            'image' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
        ],
        [
            'name' => 'Royal Suite',
            'description' => 'Ultimate luxury experience',
            'price' => Room::where('capacity', 4)->value('price_per_night') ?? 200.00,
            'image' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
        ],
    ];

    return view('welcome', compact('stats', 'availableRooms', 'roomTypes'));
});



// Guest Booking Routes (Public)

Route::get('/book-now', [BookingController::class, 'create'])->name('booking.create');

Route::post('/book-now', [BookingController::class, 'store'])->name('booking.store');



// Route untuk Rooms

Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');

Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');



/*

|--------------------------------------------------------------------------

| Authenticated User Routes (Regular Users/Guests)

|--------------------------------------------------------------------------

*/



Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard redirect logic

    Route::get('/dashboard', function () {

        if (auth()->user()->isStaff()) {

            return redirect()->route('staff.dashboard');

        }
        
        $boardingHouses = BoardingHouse::where('is_verified', true)->latest()->take(6)->get();
        return view('guest.dashboard', compact('boardingHouses'));

    })->name('dashboard');

    // Guest-facing Boarding House List
    Route::get('/kos', [GuestPageController::class, 'index'])->name('guest.boarding-houses.index');
    Route::get('/kos/{boarding_house}', [GuestPageController::class, 'show'])->name('guest.boarding-houses.show');



        // Guest Bookings



        Route::get('/my-bookings', [BookingController::class, 'index'])->name('booking.index');



        Route::get('/my-bookings/{booking}', [BookingController::class, 'show'])->name('guest.bookings.show');
        Route::put('/my-bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('guest.bookings.cancel');



    // Profile Management
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserProfileController::class, 'update'])->name('profile.update');

    // Account Settings
    Route::get('/account', [AccountController::class, 'edit'])->name('account.edit');
    Route::patch('/account', [AccountController::class, 'update'])->name('account.update');
    Route::delete('/account', [AccountController::class, 'destroy'])->name('account.destroy');
});

/*
        // Profile Management



        Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');



        Route::patch('/profile', [UserProfileController::class, 'update'])->name('profile.update');



        Route::delete('/profile', [UserProfileController::class, 'destroy'])->name('profile.destroy');



    // Verification Routes

    Route::prefix('verification')->name('verification.')->group(function () {

        Route::get('/', [VerificationController::class, 'index'])->name('index');

        Route::get('/{boardingHouse}', [VerificationController::class, 'show'])->name('show');

        Route::post('/{boardingHouse}/approve', [VerificationController::class, 'approve'])->name('approve');

        Route::post('/{boardingHouse}/reject', [VerificationController::class, 'reject'])->name('reject');

    });

});



/*

|--------------------------------------------------------------------------

| Superadmin Routes (Superadmin Only)

|--------------------------------------------------------------------------

*/




Route::middleware(['auth', 'verified', 'staff:superadmin'])->group(function () {

    // Master Data - Districts

    Route::resource('districts', DistrictController::class)->except(['show']);



    // Master Data - Facilities

    Route::resource('facilities', FacilityController::class)->except(['show']);

    // Admin Approvals
    Route::get('/superadmin/approvals', [\App\Http\Controllers\SuperadminController::class, 'index'])->name('superadmin.approvals');
    Route::post('/superadmin/approvals/{user}/approve', [\App\Http\Controllers\SuperadminController::class, 'approve'])->name('superadmin.approvals.approve');
    Route::post('/superadmin/approvals/{user}/reject', [\App\Http\Controllers\SuperadminController::class, 'reject'])->name('superadmin.approvals.reject');

});



/*

|--------------------------------------------------------------------------

| Admin Routes (Admin/Boarding House Owner Only)

|--------------------------------------------------------------------------

*/



Route::middleware(['auth', 'verified', 'staff'])->group(function () {

    // Admin Dashboard

    Route::get('/staff/dashboard', [DashboardController::class, 'index'])->name('staff.dashboard');



    // Boarding Houses Management (Policy handles admin-only access)

    Route::resource('boarding-houses', BoardingHouseController::class);



    // Nested Rooms Management (inside boarding house)

    Route::prefix('boarding-houses/{boarding_house}')->name('boarding-houses.')->group(function () {

        Route::resource('rooms', RoomController::class)->except(['index', 'show']);

    });



    // Legacy Routes (Old Hotel Management System)

    Route::resource('rooms', RoomController::class)->names([

        'index' => 'legacy.rooms.index',

        'create' => 'legacy.rooms.create',

        'store' => 'legacy.rooms.store',

        'show' => 'legacy.rooms.show',

        'edit' => 'legacy.rooms.edit',

        'update' => 'legacy.rooms.update',

        'destroy' => 'legacy.rooms.destroy',

    ]);

    Route::resource('guests', GuestController::class);

    Route::resource('bookings', BookingController::class)->except(['create', 'store']);

    Route::patch('/bookings/{booking}/checkout', [BookingController::class, 'checkout'])->name('bookings.checkout');
    Route::get('/bookings/get-available-rooms/{boardingHouseId}', [BookingController::class, 'getAvailableRooms'])->name('bookings.get_available_rooms');

});




/*

|--------------------------------------------------------------------------

| Authentication Routes

|--------------------------------------------------------------------------

*/

// Route untuk Rooms
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('verification')->name('verification.')->group(function () {
        Route::get('/', [VerificationController::class, 'index'])->name('index');
        Route::get('/{boardingHouse}', [VerificationController::class, 'show'])->name('show');
        Route::post('/{boardingHouse}/approve', [VerificationController::class, 'approve'])->name('approve');
        Route::post('/{boardingHouse}/reject', [VerificationController::class, 'reject'])->name('reject');
    });
});
// Hanya superadmin yang boleh melihat halaman ini
Route::middleware(['auth', 'role:superadmin'])->group(function () {

    Route::get('/verified', [\App\Http\Controllers\VerifiedController::class, 'index'])
        ->name('verified.index');

    Route::post('/verified/{kos}/accept', [\App\Http\Controllers\VerifiedController::class, 'accept'])
        ->name('verified.accept');

    Route::post('/verified/{kos}/reject', [\App\Http\Controllers\VerifiedController::class, 'reject'])
        ->name('verified.reject');
});

require __DIR__ . '/auth.php';

