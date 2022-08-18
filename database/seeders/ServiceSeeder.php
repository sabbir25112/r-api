<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::insert([
            [
                'name' => 'Rapido E-Commerce (Parcel Delivery)'
            ],

            [
                'name' => 'Rapido Foodie (Food Delivery)'
            ],
        ]);
    }
}
