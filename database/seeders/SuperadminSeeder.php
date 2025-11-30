<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@ekost.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
        User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@ekost.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            'email_verified_at' => now(),
        ]);
        $this->command->info('Superadmin created successfully!');
        $this->command->info('Email: superadmin@ekost.com');
        $this->command->info('Email: admin@ekost.com');
        $this->command->info('Password: password');
    }
}