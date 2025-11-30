<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            // New fields for boarding house system
            $table->foreignId('boarding_house_id')->nullable()->after('id')->constrained('boarding_houses')->onDelete('cascade');
            $table->string('type_name', 100)->nullable()->after('boarding_house_id');
            $table->decimal('price_per_month', 10, 2)->nullable()->after('price_per_night');
            $table->integer('availability')->nullable()->after('capacity')->comment('Total units of this room type');
            $table->integer('available_units')->nullable()->after('availability')->comment('Available units (availability - active bookings)');
            $table->string('size', 50)->nullable()->after('available_units');
            $table->string('image_path')->nullable()->after('size');
            $table->softDeletes();

            $table->index('boarding_house_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropForeign(['boarding_house_id']);
            $table->dropIndex(['boarding_house_id']);
            $table->dropColumn([
                'boarding_house_id',
                'type_name',
                'price_per_month',
                'availability',
                'available_units',
                'size',
                'image_path',
                'deleted_at'
            ]);
        });
    }
};