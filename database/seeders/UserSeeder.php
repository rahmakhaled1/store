<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\password;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'Rahma Khaled',
            'email'=>'r@gmail.com',
            'password'=>Hash::make('password'),
            'phone_num'=>'01030349098',
        ]);
        User::create([
            'name'=>'Ahmed Helal',
            'email'=>'a@gmail.com',
            'password'=>Hash::make('password'),
            'phone_num'=>'01030349090',
        ]);
    }
}
