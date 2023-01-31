<?php

return [
    'monthly_membership_price' => (int)env('MONTHLY_MEMBERSHIP_PRICE', '1000000'),
    'payment_status' => ['0' => 'Unpaid', '1' => 'Waiting Approval', '2' => 'Paid', '3' => 'Rejected'],
    'months' => array(
        '1' => 'January',
        '2' => 'February',
        '3' => 'March',
        '4' => 'April',
        '5' => 'May',
        '6' => 'June',
        '7' => 'July',
        '8' => 'August',
        '9' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December'
    )
];
