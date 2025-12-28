<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Akun Admin
            \App\Models\User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@test.com',
                'role' => 'admin',
                'password' => bcrypt('admin123'), // passwordnya: password
            ]);

            // Akun Editor
            \App\Models\User::factory()->create([
                'name' => 'Editor',
                'email' => 'editor@test.com',
                'role' => 'editor',
                'password' => bcrypt('editor123'),
            ]);

            // Akun Viewer
            \App\Models\User::factory()->create([
                'name' => 'Viewer',
                'email' => 'viewer@test.com',
                'role' => 'viewer',
                'password' => bcrypt('viewer123'),
            ]);
    }
}
