<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = [
            // Kamar
            ['name' => 'AC', 'icon' => 'snowflake'],
            ['name' => 'Kipas Angin', 'icon' => 'wind'],
            ['name' => 'Kasur', 'icon' => 'bed'],
            ['name' => 'Lemari', 'icon' => 'door-closed'],
            ['name' => 'Meja Belajar', 'icon' => 'desk'],
            ['name' => 'Kursi', 'icon' => 'chair'],
            ['name' => 'Kamar Mandi Dalam', 'icon' => 'bath'],
            ['name' => 'Jendela', 'icon' => 'window-maximize'],

            // Umum
            ['name' => 'WiFi', 'icon' => 'wifi'],
            ['name' => 'Parkir Motor', 'icon' => 'motorcycle'],
            ['name' => 'Parkir Mobil', 'icon' => 'car'],
            ['name' => 'Dapur Bersama', 'icon' => 'utensils'],
            ['name' => 'Kulkas', 'icon' => 'box'],
            ['name' => 'Mesin Cuci', 'icon' => 'tshirt'],
            ['name' => 'Jemuran', 'icon' => 'wind'],
            ['name' => 'Ruang Tamu', 'icon' => 'couch'],
            ['name' => 'CCTV', 'icon' => 'video'],
            ['name' => 'Penjaga Kos', 'icon' => 'user-shield'],
        ];

        foreach ($facilities as $item) {
            Facility::firstOrCreate(
                ['name' => $item['name']],
                ['icon' => $item['icon']]
            );
        }

        $this->command->info('Facilities seeded successfully!');
        $this->command->info('Total: ' . Facility::count() . ' facilities');
    }
}