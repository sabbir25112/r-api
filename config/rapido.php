<?php

return [
    'status_flow' => [
        'placed'        => ['accepted', 'cancelled'],
        'accepted'      => ['picked_up', 'cancelled'],
        'picked_up'     => ['delivering', 'cancelled'],
        'delivering'    => ['on_courier', 'cancelled'],
        'on_courier'    => ['delivered', 'cancelled'],
        'delivered'     => ['completed']
    ]
];
