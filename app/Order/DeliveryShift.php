<?php

namespace App\Order;

class DeliveryShift
{
    const ANY_TIME  = 'any_time';
    const MORNING   = 'morning';
    const AFTERNOON = 'afternoon';
    const EVENING   = 'evening';

    const SHIFTS = [
        self::ANY_TIME,
        self::MORNING,
        self::AFTERNOON,
        self::EVENING,
    ];
}
