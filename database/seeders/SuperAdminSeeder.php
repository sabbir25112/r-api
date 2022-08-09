<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            [
                'name' => 'Admin',
                'email' => 'admin@rapido.com',
                'password' => bcrypt(12345678),
                'user_type' => User::SUPERADMIN,
            ]
        ]);
    }
}
