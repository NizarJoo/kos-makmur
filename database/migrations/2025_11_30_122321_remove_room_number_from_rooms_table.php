<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            // Cek apakah kolom room_number ada
            if (Schema::hasColumn('rooms', 'room_number')) {
                // Drop unique index dulu (dengan pengecekan)
                try {
                    $table->dropUnique(['room_number']);
                } catch (\Exception $e) {
                    // Index tidak ada, skip
                }
                
                // Drop column
                $table->dropColumn('room_number');
            }
        });
    }

    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            if (!Schema::hasColumn('rooms', 'room_number')) {
                $table->string('room_number')->nullable();
                $table->unique('room_number');
            }
        });
    }
};