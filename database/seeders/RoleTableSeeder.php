<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'Admin']);
        $role->givePermissionTo('user_manage');

        $role = Role::create(['name' => 'User']);
        $role->givePermissionTo('qrcode_manage');
    }
}
