<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeed extends Seeder{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        User::create([
            'name'=>'Vishal',
            'email'=>'admin@gmail.com',
            'password'=>'Admin@123',
            'number'=>1234567890,
            'user_type'=>'admin'
        ]);
    }
}
