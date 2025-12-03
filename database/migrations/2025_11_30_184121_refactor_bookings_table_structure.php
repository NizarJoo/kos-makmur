<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_code', 50)->unique();

            // Foreign Keys
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('restrict');
            $table->foreignId('boarding_house_id')->constrained('kos')->onDelete('restrict');

            // Periode
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('duration_months');

            // Pembayaran
            $table->decimal('total_price', 10, 2);

            // Status & Notes
            $table->enum('status', ['pending', 'approved', 'rejected', 'active', 'finished', 'cancelled'])
                ->default('pending');
            $table->text('notes')->nullable();
            $table->text('rejection_reason')->nullable();

            $table->timestamps();

            // Indexes untuk performance
            $table->index('user_id');
            $table->index('room_id');
            $table->index('boarding_house_id');
            $table->index('status');
            $table->index('booking_code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};