<?php

namespace Database\Seeders;

use App\Models\UserAllowed;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserAllowedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserAllowed::create([
            'name' => 'Kevin Sipahutar',
            'email' => '2210631250017@student.unsika.ac.id'
        ]);
    }
}
