<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Drop columns lama yang gak dipake
            $table->dropColumn([
                'capacity',
                'price_per_night',
                'status',
                'featured_image',
                'gallery_images',
                'room_type',
                'amenities'
            ]);
        });

        Schema::table('rooms', function (Blueprint $table) {
            // Tambah columns baru sesuai sistem kost
            $table->foreignId('boarding_house_id')->constrained()->onDelete('cascade');
            $table->string('type_name', 100);
            $table->decimal('price_per_month', 10, 2);
            $table->integer('availability'); // total units
            $table->integer('available_units')->default(0); // units yang masih kosong
            $table->string('size', 50)->nullable();
            $table->string('image_path')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropForeign(['boarding_house_id']);
            $table->dropColumn([
                'boarding_house_id',
                'type_name',
                'price_per_month',
                'availability',
                'available_units',
                'size',
                'image_path'
            ]);
        });

        Schema::table('rooms', function (Blueprint $table) {
            $table->integer('capacity');
            $table->decimal('price_per_night', 10, 2);
            $table->enum('status', ['available', 'occupied', 'maintenance'])->default('available');
            $table->string('featured_image')->nullable();
            $table->json('gallery_images')->nullable();
            $table->string('room_type')->nullable();
            $table->json('amenities')->nullable();
        });
    }
};