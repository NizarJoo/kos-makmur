<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Drop unique index dulu sebelum drop column
            $table->dropUnique(['room_number']);
        });

        Schema::table('rooms', function (Blueprint $table) {
            // Baru drop column-nya
            $table->dropColumn('room_number');
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->string('room_number')->nullable();
            $table->unique('room_number');
        });
    }
};