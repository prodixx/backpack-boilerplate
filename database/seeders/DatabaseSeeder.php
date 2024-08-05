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
        $this->call(RolesTableSeeder::class);

        // User::factory(10)->create();

        $users = [
            [
                'name' => 'Catalin Prodan',
                'email' => 'catalin.prodan@newpixel.ro',
                'password' => '$2y$10$gNwuvzWGZR6ylkL01ziGkuF6GGAUg3qH4Egnl/wMbuyjBAOrUvHpa',
                'role' => 'superadmin',
            ],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => $user['password'],
            ])->assignRole($user['role']);
        }
    }
}
