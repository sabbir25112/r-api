<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::insert([
            ['name' => 'role.create',],
            ['name' => 'role.assign',],
            ['name' => 'permission.assign',],
            ['name' => 'user.create',]
        ]);

    }
}
