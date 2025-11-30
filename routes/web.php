<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\GuestBookingController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\BoardingHouseController;
use App\Models\Room;
use App\Models\Guest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuestBookingController;

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
            'name' => 'Kos Avenger',
            'description' => 'Kos nyaman untuk 1 keluarga',
            'price' => Room::where('capacity', 2)->value('price_per_night') ?? 1000,
            'image' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
        ],
        [
            'name' => 'Kos Muslimah Ambarawa',
            'description' => 'Kos ekslusif mahasiswi sultan',
            'price' => Room::where('capacity', 3)->value('price_per_night') ?? 550,
            'image' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
        ],
        [
            'name' => 'Kos Syahdana',
            'description' => 'Kos strategis dekat kampus UM',
            'price' => Room::where('capacity', 4)->value('price_per_night') ?? 100,
            'image' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80'
        ],
    ];

    return view('welcome', compact('stats', 'availableRooms', 'roomTypes'));
});

// Guest Booking Routes (Public)
Route::get('/book-now', [GuestBookingController::class, 'create'])->name('guest.booking.create');
Route::post('/book-now', [GuestBookingController::class, 'store'])->name('guest.booking.store');

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
        return view('guest.dashboard');
    })->name('dashboard');

    // Guest Bookings
    Route::get('/my-bookings', [GuestBookingController::class, 'index'])->name('guest.bookings');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Profile Biodata routes
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserProfileController::class, 'update'])->name('profile.update');

    // Account routes (email, password, delete account)
    Route::get('/account', [AccountController::class, 'edit'])->name('account.edit');
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

    // Legacy Routes (Old Hotel Management System)
    Route::resource('rooms', RoomController::class);
    Route::resource('guests', GuestController::class);
    Route::resource('bookings', BookingController::class);
    Route::patch('/bookings/{booking}/checkout', [BookingController::class, 'checkout'])->name('bookings.checkout');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';