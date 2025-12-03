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
            // Tambah kolom dengan pengecekan
            if (!Schema::hasColumn('bookings', 'booking_code')) {
                $table->string('booking_code', 50)->nullable()->after('id');
            }
            if (!Schema::hasColumn('bookings', 'duration_months')) {
                $table->integer('duration_months')->nullable()->after('check_out_date');
            }
            if (!Schema::hasColumn('bookings', 'notes')) {
                $table->text('notes')->nullable()->after('status');
            }
            if (!Schema::hasColumn('bookings', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('notes');
            }
        });

        // Isi data untuk booking yang sudah ada (cek dulu ada data atau tidak)
        $bookings = DB::table('bookings')->whereNull('booking_code')->get();

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
        if (Schema::hasColumn('bookings', 'booking_code')) {
            // Cek apakah index sudah ada
            $indexExists = false;
            try {
                $indexes = DB::select("PRAGMA index_list('bookings')");
                foreach ($indexes as $index) {
                    if ($index->name === 'bookings_booking_code_unique') {
                        $indexExists = true;
                        break;
                    }
                }
            } catch (\Exception $e) {
                // Ignore error
            }

            Schema::table('bookings', function (Blueprint $table) use ($indexExists) {
                if (!$indexExists) {
                    $table->string('booking_code', 50)->nullable(false)->unique()->change();
                } else {
                    $table->string('booking_code', 50)->nullable(false)->change();
                }
            });
        }

        if (Schema::hasColumn('bookings', 'duration_months')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->integer('duration_months')->nullable(false)->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $columnsToCheck = ['booking_code', 'duration_months', 'notes', 'rejection_reason'];

            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('bookings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};