<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => '12345678',
            'role' => 'admin'
        ]);
    
        User::factory()->create([
            'name' => 'Normal User',
            'email' => 'normal1@example.com',
            'password' => '12345678',
            'role' => 'user'
        ]);
        User::factory()->create([
            'name' => 'Normal User2',
            'email' => 'normal2@example.com',
            'password' => '12345678',
            'role' => 'user'
        ]);
    }
}
