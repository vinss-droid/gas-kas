<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Kevin',
            'email' => '2210631250017@student.unsika.ac.id',
            'password' => Hash::make('qwerty'),
            'email_verified_at' => now(),
        ]);
    }
}
