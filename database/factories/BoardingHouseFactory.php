<?php

namespace Database\Factories;

use App\Models\BoardingHouse;
use App\Models\District;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BoardingHouse>
 */
class BoardingHouseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BoardingHouse::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get a random user with the 'admin' role.
        // This assumes you have a way to distinguish admin users.
        // If not, you might need to create one or fetch any user.
        $admin = User::where('role', 'admin')->inRandomOrder()->first();
        if (!$admin) {
            // Fallback to creating a new admin user if none exist
            $admin = User::factory()->create(['role' => 'admin']);
        }

        // Get a random district
        $district = District::inRandomOrder()->first();
        if (!$district) {
            // Fallback to creating a new district if none exist
            // This assumes you have a DistrictFactory. If not, create one or seed them first.
            $district = \App\Models\District::factory()->create();
        }


        return [
            'admin_id' => $admin->id,
            'name' => 'Kos ' . $this->faker->unique()->words(2, true),
            'address' => $this->faker->address,
            'district_id' => $district->id,
            'description' => $this->faker->realText(200),
            'image_path' => null, // Or $this->faker->imageUrl() if you want placeholder images
            'type' => $this->faker->randomElement(['male', 'female', 'mixed']),
            'is_verified' => true, // Set to true to be visible for guests
        ];
    }
}