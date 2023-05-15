<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::create([
            'name' => env('ADMIN_NAME', 'admin'),
            'surname' => env('ADMIN_SURNAME', 'sure'),
            'email' => env('ADMIN_EMAIL', 'admin@admin.com'),
            'password' => env('ADMIN_PASSWORD', 'password'),
        ]);

        $user->assignRole('Admin');
    }
}
