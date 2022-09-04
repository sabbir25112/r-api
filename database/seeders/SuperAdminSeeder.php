<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ADD SUPER ADMIN
        User::insert([
            [
                'name'      => 'Admin',
                'email'     => 'admin@rapido.com',
                'password'  => bcrypt(12345678),
                'user_type' => User::SUPERADMIN,
            ]
        ]);

        // ADD ADMIN ROLE
        Role::insert([
            [
                'name'          => 'Admin',
                'guard_name'    => 'api',
            ]
        ]);

        // ASSIGN ALL PERMISSIONS TO ADMIN ROLE
        for($i = 1; $i<=42; $i++){
            DB::table('role_has_permissions')->insert([
                [
                    'permission_id' => $i,
                    'role_id'       => 1,
                ],
            ]);
        }

        //ASSIGN ADMIN ROLE TO SUPER ADMIN
        DB::table('model_has_roles')->insert([
            [
                'role_id'       => 1,
                'model_type'    => 'App\Models\User',
                'model_id'      => 1,
            ],
        ]);
    }
}
