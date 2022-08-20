<?php

namespace App\Order;

class Status
{
    const PLACED = 'placed';
    const ACCEPTED = 'accepted';
    const PICKED_UP = 'picked_up';
    const DELIVERING = 'delivering';
    const ON_COURIER = 'on_courier';
    const CANCELLED = 'cancelled';
    const DELIVERED = 'delivered';
    const COMPLETED = 'completed';
}
