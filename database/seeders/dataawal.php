<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class dataawal extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User;
        $user->name = "Admin";
        $user->email = "admin@mail.com";
        $user->password = bcrypt('12345678');
        $user->role = "admin";
        $user->save();
    }
}
