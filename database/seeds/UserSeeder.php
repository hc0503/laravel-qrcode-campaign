<?php

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
        App\User::create([
            'name' => 'xiao',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'),
        ]);
    }
}
