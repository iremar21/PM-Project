<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Solvam Admin',
            'email' => 'solvam@admin.com',
            'password' => bcrypt('12345678'),
            'active' => true,
        ])->assignRole('Admin');

        User::create([
            'name' => 'Solvam User',
            'email' => 'solvam@user.com',
            'password' => bcrypt('12345678'),
            'active' => true,
        ])->assignRole('Usuario');

        // User::factory(9)->create();

        User::factory()
            ->count(11)
            ->create()
            ->each(function($user) {
                $user->assignRole('Usuario');
            });
    }
}
