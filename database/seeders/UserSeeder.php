<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
              'name' => 'Admin',
              'username' => 'admin',
              'email' => 'admin@email.com',
              'password' => \Hash::make('welcome123'),
              'is_active' => 1
            ]
        ];

        User::insert($users);
    }
}
