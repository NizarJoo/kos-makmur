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
    Route::resource('bookings', BookingController::class);
    Route::patch('/bookings/{booking}/checkout', [BookingController::class, 'checkout'])->name('bookings.checkout');
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

require __DIR__ . '/auth.php';