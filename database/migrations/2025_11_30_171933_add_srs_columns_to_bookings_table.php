<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Tambah kolom dengan NULLABLE dulu, nanti kita isi
            $table->string('booking_code', 50)->nullable()->after('id');
            $table->integer('duration_months')->nullable()->after('check_out_date');
            $table->text('notes')->nullable()->after('status');
            $table->text('rejection_reason')->nullable()->after('notes');
        });

        // Isi data untuk booking yang sudah ada
        $bookings = DB::table('bookings')->get();

        foreach ($bookings as $booking) {
            // Generate booking_code untuk data lama
            $bookingCode = 'BOOK-' . date('Ymd') . '-' . strtoupper(Str::random(5));

            // Hitung duration_months dari check_in_date dan check_out_date
            $checkIn = \Carbon\Carbon::parse($booking->check_in_date);
            $checkOut = \Carbon\Carbon::parse($booking->check_out_date);
            $totalDays = $checkIn->diffInDays($checkOut);
            $durationMonths = (int) ceil($totalDays / 30);

            DB::table('bookings')
                ->where('id', $booking->id)
                ->update([
                    'booking_code' => $bookingCode,
                    'duration_months' => $durationMonths,
                ]);
        }

        // Sekarang baru ubah booking_code jadi NOT NULL dan UNIQUE
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('booking_code', 50)->nullable(false)->unique()->change();
            $table->integer('duration_months')->nullable(false)->change();
        });

        // Update enum status (untuk SQLite, kita skip ini dulu karena ribet)
        // Kalau pakai MySQL, uncomment baris di bawah:
        // DB::statement("ALTER TABLE bookings MODIFY status ENUM('pending', 'approved', 'rejected', 'active', 'finished', 'cancelled') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['booking_code', 'duration_months', 'notes', 'rejection_reason']);
        });
    }
};