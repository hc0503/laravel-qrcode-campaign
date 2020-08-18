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
        $user = App\Models\User::create([
            'name' => 'Admin',
            'surname' => 'Sure',
            'email' => 'admin@admin.com',
            'password' => 'password',
        ]);

        $user->assignRole('Admin');
    }
}
