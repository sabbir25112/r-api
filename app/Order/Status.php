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

    const TYPES = [
        self::PLACED,
        self::ACCEPTED,
        self::PICKED_UP,
        self::DELIVERING,
        self::ON_COURIER,
        self::CANCELLED,
        self::DELIVERED,
        self::COMPLETED,
    ];
}
