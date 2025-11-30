<?php

namespace Database\Seeders;

use App\Models\BoardingHouse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BoardingHouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 25 boarding houses using the factory
        BoardingHouse::factory()->count(25)->create();
    }
}