<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('boarding_house_id')->constrained('boarding_houses')->onDelete('cascade');
            
            $table->string('type_name', 100); // Tipe kamar (Standard, Deluxe, VIP)
            $table->string('size', 50)->nullable(); // Ukuran kamar (3x4m)
            $table->decimal('price_per_month', 10, 2); // Harga per bulan
            
            // Availability management
            $table->integer('availability')->default(0)->comment('Total units available');
            $table->integer('available_units')->default(0)->comment('Units yang bisa di-booking');
            
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index('boarding_house_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};