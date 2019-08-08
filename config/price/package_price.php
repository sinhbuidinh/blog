<?php

return [
    'define' => [
        1 => 'ong-nhua',
        2 => 'carton',
        3 => 'thanh-go',
        4 => 'van-ep+xop',
    ],
    'weight_by' => [
        1 => 'Kilogram',
        2 => 'LCD',
        3 => 'Laptop',
        4 => 'Mililit',
    ],
    'kg' => [
        '0-5' => [
            2 => 10000,
            3 => 50000,
            4 => 60000,
        ],
        '5-10' => [
            2 => 20000,
            3 => 70000,
            4 => 80000,
        ],
        '10-50' => [
            2 => 40000,
            3 => 100000,
            4 => 140000,
        ],
        '50-70' => [
            2 => 60000,
            3 => 140000,
            4 => 200000,
        ],
        '70-100' => [
            2 => 80000,
            3 => 200000,
            4 => 260000,
        ],
    ],
    'lcd' => [
        'lcd32' => [
            3 => 100000,
            4 => 120000,
        ],
        'lcd64' => [
            3 => 150000,
            4 => 170000,
        ],
    ],
    'laptop' => [
        "0-10" => [
            4 => 100000
        ]
    ],
    'ml' => [
        '0-250' => [
            1 => 30000,
            2 => 30000
        ],
    ],
];
