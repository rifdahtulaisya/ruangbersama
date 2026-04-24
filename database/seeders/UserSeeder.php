<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat 10 user dengan role 'user'
        $users = [
            [
                'username' => 'rifdah',
                'name' => 'Rifdahtul Aisya',
                'number' => '20240001',
                'role' => 'user',
                'email' => 'rifda@example.com',
                'password' => Hash::make('rifdah123'),
            ],
            [
                'username' => 'milda',
                'name' => 'Sri Milda',
                'number' => '20240002',
                'role' => 'user',
                'email' => 'milda@example.com',
                'password' => Hash::make('milda123'),
            ],
            [
                'username' => 'safira',
                'name' => 'Safira Putri',
                'number' => '20240003',
                'role' => 'user',
                'email' => 'safira@example.com',
                'password' => Hash::make('safira123'),
            ],
            [
                'username' => 'gadis',
                'name' => 'Gadis Zienlina',
                'number' => '20240004',
                'role' => 'user',
                'email' => 'gadis.zienlina@example.com',
                'password' => Hash::make('gadis123'),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $this->command->info('Seeder user dengan role "user" berhasil dijalankan!');
        $this->command->info('Total user: ' . count($users));
    }
}