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
use App\Http\Controllers\StaffBookingController;
use App\Models\BoardingHouse;
use App\Models\Room;
use App\Models\Guest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerificationController;
use App\Models\District;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $stats = [
        'boardingHouseCount' => BoardingHouse::verified()->count(),
        'districtCount' => District::count(),
    ];

    $availableRooms = Room::where('status', 'available')->count();

    $boardingHouses = BoardingHouse::where('is_verified', true)->latest()->take(3)->get();

    return view('welcome', compact('stats', 'availableRooms', 'boardingHouses'));
});

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
        return view('guest.dashboard_new', compact('boardingHouses'));
    })->name('dashboard');

    // Guest-facing Boarding House List
    Route::get('/kos', [GuestPageController::class, 'index'])->name('guest.boarding-houses.index');
    Route::get('/kos/{boarding_house}', [GuestPageController::class, 'show'])->name('guest.boarding-houses.show');

    // Guest Bookings
    Route::get('/book-now', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/book-now', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/my-bookings', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/my-bookings/{booking}', [BookingController::class, 'show'])->name('guest.bookings.show');
    Route::put('/my-bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('guest.bookings.cancel');
    
    // AJAX route for getting rooms
    Route::get('/bookings/get-available-rooms/{boardingHouseId}', [BookingController::class, 'getAvailableRooms'])->name('bookings.get_available_rooms');

    // Profile & Account Management
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::patch('/account', [AccountController::class, 'update'])->name('account.update');
    Route::delete('/account', [AccountController::class, 'destroy'])->name('account.destroy');
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

    // Verification Routes for Superadmin
    Route::prefix('verification')->name('verification.')->group(function () {
        Route::get('/', [VerificationController::class, 'index'])->name('index');
        Route::get('/{boardingHouse}', [VerificationController::class, 'show'])->name('show');
        Route::post('/{boardingHouse}/approve', [VerificationController::class, 'approve'])->name('approve');
        Route::post('/{boardingHouse}/reject', [VerificationController::class, 'reject'])->name('reject');
    });
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

    // Staff Bookings Management
    Route::prefix('staff/bookings')->name('staff.bookings.')->group(function () {
        Route::get('/', [StaffBookingController::class, 'index'])->name('index');
        Route::get('/create', [StaffBookingController::class, 'create'])->name('create');
        Route::post('/', [StaffBookingController::class, 'store'])->name('store');
        Route::post('/{booking}/approve', [StaffBookingController::class, 'approve'])->name('approve');
        Route::post('/{booking}/reject', [StaffBookingController::class, 'reject'])->name('reject');
    });

    Route::resource('guests', GuestController::class);
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';

Route::get('/legacy/rooms', [RoomController::class, 'index'])->name('legacy.rooms.index');