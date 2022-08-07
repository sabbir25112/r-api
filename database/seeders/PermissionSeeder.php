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
            [
                'name' => 'role.create',
                'guard_name' => 'api',
            ],
            [
                'name' => 'role.assign',
                'guard_name' => 'api',
            ],
            [
                'name' => 'permission.assign',
                'guard_name' => 'api',
            ],
            [
                'name' => 'user.create',
                'guard_name' => 'api',
            ]
        ]);

    }
}
