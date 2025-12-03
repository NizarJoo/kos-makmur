<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Drop columns lama yang gak dipake (dengan pengecekan)
            $columnsToCheck = [
                'capacity',
                'price_per_night',
                'status',
                'featured_image',
                'gallery_images',
                'room_type',
                'amenities'
            ];

            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('rooms', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Cek foreign key sebelum drop
            if (Schema::hasColumn('rooms', 'boarding_house_id')) {
                try {
                    $table->dropForeign(['boarding_house_id']);
                } catch (\Exception $e) {
                    // Foreign key tidak ada, skip
                }

                $table->dropColumn([
                    'boarding_house_id',
                    'type_name',
                    'price_per_month',
                    'availability',
                    'available_units',
                    'size',
                    'image_path'
                ]);
            }
        });

        Schema::table('rooms', function (Blueprint $table) {
            // Restore kolom lama
            if (!Schema::hasColumn('rooms', 'capacity')) {
                $table->integer('capacity')->nullable();
            }
            if (!Schema::hasColumn('rooms', 'price_per_night')) {
                $table->decimal('price_per_night', 10, 2)->nullable();
            }
            if (!Schema::hasColumn('rooms', 'status')) {
                $table->enum('status', ['available', 'occupied', 'maintenance'])->default('available');
            }
            if (!Schema::hasColumn('rooms', 'featured_image')) {
                $table->string('featured_image')->nullable();
            }
            if (!Schema::hasColumn('rooms', 'gallery_images')) {
                $table->json('gallery_images')->nullable();
            }
            if (!Schema::hasColumn('rooms', 'room_type')) {
                $table->string('room_type')->nullable();
            }
            if (!Schema::hasColumn('rooms', 'amenities')) {
                $table->json('amenities')->nullable();
            }
        });
    }
};