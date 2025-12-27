<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pemilik>
 */
class PemilikFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_lengkap'  =>fake()->name(),
            'alamat'        =>fake()->address(),
            'nomor_telepon' =>fake()->phoneNumber(),
            'email'         =>fake()->unique()->safeEmail(),
        ];
    }
}
