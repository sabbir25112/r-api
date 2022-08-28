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
                'name' => 'permission.remove',
                'guard_name' => 'api',
            ],

            [
                'name' => 'user.create',
                'guard_name' => 'api',
            ],

            [
                'name' => 'city.create',
                'guard_name' => 'api',
            ],
            [
                'name' => 'city.update',
                'guard_name' => 'api',
            ],
            [
                'name' => 'city.delete',
                'guard_name' => 'api',
            ],

            [
                'name' => 'zone.create',
                'guard_name' => 'api',
            ],
            [
                'name' => 'zone.update',
                'guard_name' => 'api',
            ],
            [
                'name' => 'zone.delete',
                'guard_name' => 'api',
            ],

            [
                'name' => 'merchant.create',
                'guard_name' => 'api',
            ],
            [
                'name' => 'merchant.update',
                'guard_name' => 'api',
            ],
            [
                'name' => 'merchant.delete',
                'guard_name' => 'api',
            ],

            [
                'name' => 'order.create',
                'guard_name' => 'api',
            ],
            [
                'name' => 'order.update',
                'guard_name' => 'api',
            ],
            [
                'name' => 'order.delete',
                'guard_name' => 'api',
            ],

            [
                'name' => 'parcel.order.update',
                'guard_name' => 'api',
            ],
            [
                'name' => 'parcel.order.delete',
                'guard_name' => 'api',
            ],

            [
                'name' => 'parcel.update',
                'guard_name' => 'api',
            ],
            [
                'name' => 'parcel.delete',
                'guard_name' => 'api',
            ],

            [
                'name' => 'change.order.status.to.accepted',
                'guard_name' => 'api',
            ],
            [
                'name' => 'change.order.status.to.picked_up',
                'guard_name' => 'api',
            ],
            [
                'name' => 'change.order.status.to.delivering',
                'guard_name' => 'api',
            ],
            [
                'name' => 'change.order.status.to.on_courier',
                'guard_name' => 'api',
            ],
            [
                'name' => 'change.order.status.to.cancelled',
                'guard_name' => 'api',
            ],
            [
                'name' => 'change.order.status.to.delivered',
                'guard_name' => 'api',
            ],
            [
                'name' => 'change.order.status.to.completed',
                'guard_name' => 'api',
            ],

            [
                'name' => 'change.parcel.order.status.to.accepted',
                'guard_name' => 'api',
            ],
            [
                'name' => 'change.parcel.order.status.to.picked_up',
                'guard_name' => 'api',
            ],
            [
                'name' => 'change.parcel.order.status.to.delivering',
                'guard_name' => 'api',
            ],
            [
                'name' => 'change.parcel.order.status.to.on_courier',
                'guard_name' => 'api',
            ],
            [
                'name' => 'change.parcel.order.status.to.cancelled',
                'guard_name' => 'api',
            ],
            [
                'name' => 'change.parcel.order.status.to.delivered',
                'guard_name' => 'api',
            ],
            [
                'name' => 'change.parcel.order.status.to.completed',
                'guard_name' => 'api',
            ],

            [
                'name' => 'change.parcel.status.to.accepted',
                'guard_name' => 'api',
            ],
            [
                'name' => 'change.parcel.status.to.picked_up',
                'guard_name' => 'api',
            ],
            [
                'name' => 'change.parcel.status.to.delivering',
                'guard_name' => 'api',
            ],
            [
                'name' => 'change.parcel.status.to.on_courier',
                'guard_name' => 'api',
            ],
            [
                'name' => 'change.parcel.status.to.cancelled',
                'guard_name' => 'api',
            ],
            [
                'name' => 'change.parcel.status.to.delivered',
                'guard_name' => 'api',
            ],
            [
                'name' => 'change.parcel.status.to.completed',
                'guard_name' => 'api',
            ],
        ]);

    }
}
