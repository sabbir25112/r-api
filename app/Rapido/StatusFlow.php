<?php

namespace App\Rapido;

use App\Models\Order;

class StatusFlow
{
    public static function canChangeOrderStatus($order, $status)
    {
        if (!auth()->user()->can('change.order.status.to.'.$status))
        {
            return ([
                'status'    => false,
                'message'   => 'User dont have permission to change this status!',
            ]);
        }
        if (!in_array($status,config("rapido.status_flow.".$order->status)))
        {
            return ([
                'status'    => false,
                'message'   => 'Status flow violated !',
            ]);
        }

        return ([
            'status' => true,
        ]);
    }

    public static function canChangeParcelOrderStatus($parcel_order, $status)
    {
        if (!auth()->user()->can('change.parcel.order.status.to.'.$status))
        {
            return ([
                'status'    => false,
                'message'   => 'User dont have permission to change this status!',
            ]);
        }
        if (!in_array($status,config("rapido.status_flow.".$parcel_order->status)))
        {
            return ([
                'status'    => false,
                'message'   => 'Status flow violated !',
            ]);
        }

        return ([
            'status' => true,
        ]);
    }

    public static function canChangeParcelStatus($parcel, $status)
    {
        if (!auth()->user()->can('change.parcel.status.to.'.$status))
        {
            return ([
                'status'    => false,
                'message'   => 'User dont have permission to change this status!',
            ]);
        }
        if (!in_array($status,config("rapido.status_flow.".$parcel->status)))
        {
            return ([
                'status'    => false,
                'message'   => 'Status flow violated !',
            ]);
        }

        return ([
            'status' => true,
        ]);
    }
}
