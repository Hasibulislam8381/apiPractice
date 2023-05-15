<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $users = [
            ['name' => 'Himel', 'email' => 'himel@gmail.com', 'password' => '23563'],
            ['name' => 'Rina', 'email' => 'rina@gmail.com', 'password' => '23563'],
            ['name' => 'Rabbi', 'email' => 'rabbi@gmail.com', 'password' => '23563'],
            ['name' => 'Hasina', 'email' => 'hasina@gmail.com', 'password' => '23563'],
        ];
        User::insert($users);
    }
}
