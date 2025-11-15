<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan role
            $table->enum('role', ['superadmin', 'admin', 'user'])
                ->default('user')
                ->after('password');

            // Tambahkan soft delete
            $table->softDeletes()->after('updated_at');

            // Index role
            $table->index('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropColumn(['role', 'deleted_at']);
        });
    }
};
