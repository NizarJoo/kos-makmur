<?php

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

// Public routes
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

// Guest Booking Routes
Route::get('/book-now', [GuestBookingController::class, 'create'])->name('guest.booking.create');
Route::post('/book-now', [GuestBookingController::class, 'store'])->name('guest.booking.store');

// Guest Routes (authenticated users)
Route::middleware(['auth', 'verified'])->group(function () {
    // Guest Dashboard
    Route::get('/dashboard', function () {
        if (auth()->user()->is_staff) {
            return redirect()->route('staff.dashboard');
        }
        return view('guest.dashboard');
    })->name('dashboard');

    Route::get('/my-bookings', [GuestBookingController::class, 'index'])->name('guest.bookings');
    Route::get('/book-now', [GuestBookingController::class, 'create'])->name('guest.booking.create');
    Route::post('/book-now', [GuestBookingController::class, 'store'])->name('guest.booking.store');

    // Profile Biodata routes
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserProfileController::class, 'update'])->name('profile.update');

    // Account routes (email, password, delete account)
    Route::get('/account', [AccountController::class, 'edit'])->name('account.edit');
    Route::patch('/account', [AccountController::class, 'update'])->name('account.update');
    Route::delete('/account', [AccountController::class, 'destroy'])->name('account.destroy');
});

// Staff Routes
Route::middleware(['auth', 'verified', 'staff'])->group(function () {
    Route::get('/staff/dashboard', [DashboardController::class, 'index'])->name('staff.dashboard');

    Route::resource('rooms', RoomController::class);
    Route::resource('guests', GuestController::class);
    Route::resource('bookings', BookingController::class);
    Route::patch('/bookings/{booking}/checkout', [BookingController::class, 'checkout'])->name('bookings.checkout');
});

// Superadmin Routes
Route::middleware(['auth', 'verified', 'staff:superadmin'])->group(function () {
    // Master Data - Districts
    Route::resource('districts', DistrictController::class)->except(['show']);
});
Route::middleware(['auth', 'verified', 'staff:superadmin'])->group(function () {
    // Master Data - Districts
    Route::resource('districts', DistrictController::class)->except(['show']);

    // Master Data - Fasilitas
    Route::resource('facilities', FacilityController::class)->except(['show']);
});

require __DIR__ . '/auth.php';
