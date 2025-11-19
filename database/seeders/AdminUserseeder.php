<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         if (!User::where('email', 'admin@gescadmec.com')->exists()) {
            User::create([
                'email' => 'admin@gescadmec.com',
                'password' => Hash::make('secret'), 
                'role' => 'admin',
            ]);
        }
    }
    
}
