<?php

namespace App\Order;

class PaymentType
{
    const OFFICE_COLLECTION = 'office_collection';
    const BKASH = 'bkash';
    const BANK = 'bank';

    const TYPES = [
        self::OFFICE_COLLECTION,
        self::BANK,
        self::BKASH,
    ];
}
