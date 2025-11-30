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
    // JANGAN check auth di sini
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
// Authentication Routes
require __DIR__ . '/auth.php';
// Guest Booking Routes
Route::get('/book-now', [GuestBookingController::class, 'create'])->name('guest.booking.create');
Route::post('/book-now', [GuestBookingController::class, 'store'])->name('guest.booking.store');



// Guest Routes (authenticated users)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('guest.dashboard');
    })->name('dashboard');

    Route::get('/my-bookings', [GuestBookingController::class, 'index'])->name('guest.bookings');

    // Profile routes
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserProfileController::class, 'update'])->name('profile.update');

    // Account routes
    Route::get('/account', [AccountController::class, 'edit'])->name('account.edit');
    Route::patch('/account', [AccountController::class, 'update'])->name('account.update');
    Route::delete('/account', [AccountController::class, 'destroy'])->name('account.destroy');
});

// KEMBALIKAN KE STAFF ROUTES (seperti semula)

Route::middleware(['auth', 'verified', 'staff'])->group(function () {
    Route::get('/staff/dashboard', [DashboardController::class, 'index'])->name('staff.dashboard');
    Route::resource('rooms', RoomController::class);
    Route::resource('guests', GuestController::class);
    Route::resource('bookings', BookingController::class);

    // Tambahkan routes untuk approve/reject booking
    Route::patch('/bookings/{booking}/approve', [BookingController::class, 'approve'])->name('bookings.approve');
    Route::get('/bookings/{booking}/reject', [BookingController::class, 'showRejectForm'])->name('bookings.reject.form');
    Route::patch('/bookings/{booking}/reject', [BookingController::class, 'reject'])->name('bookings.reject');

    Route::patch('/bookings/{booking}/checkout', [BookingController::class, 'checkout'])->name('bookings.checkout');
});

// Superadmin Routes (tetap pakai yang baru)
Route::middleware(['auth', 'verified', 'staff:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); // PAKAI index()
    Route::resource('districts', DistrictController::class)->except(['show']);
    Route::resource('facilities', FacilityController::class)->except(['show']);
});