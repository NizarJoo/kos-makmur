<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            // Kota Malang
            'Blimbing',
            'Kedungkandang',
            'Klojen',
            'Lowokwaru',
            'Sukun',

            // Kabupaten Malang (populer untuk kos mahasiswa)
            'Dau',
            'Karangploso',
            'Singosari',
            'Lawang',
            'Pakis',
            'Tumpang',
            'Wagir',
            'Pakisaji',
            'Tajinan',
        ];

        foreach ($districts as $district) {
            District::create(['name' => $district]);
        }

        $this->command->info('Districts seeded successfully!');
        $this->command->info('Total: ' . count($districts) . ' districts');
    }
}