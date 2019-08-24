<?php

return [
    'weight_by' => 'gram',
    'define' => [
        1 => [
            79,//'hcm'
        ],
        2 => [
            74,//'binh-duong',
            75,//'dong-nai',
            77,//'ba-ria-vung-tau',
            80,//'long-an',
            82,//'tien-giang',
            86,//'vinh-long',
            92,//'can-tho',
            83,//'ben-tre',
            87,//'dong-thap',
            84,//'tra-vinh',
            93,//'hau-giang',
            94,//'soc-trang',
            72,//'tay-ninh',
            70,//'binh-phuoc',
        ],
        3 => ['other'],
    ],
    'price' => [
        'base' => [
            '0-2000' => [
                1 => 30000,
                2 => 70000,
                3 => 90000,
            ],
        ],
        'above' => [
            'every' => 500,
            'range' => [
                '0-~' => [
                    1 => 3000,
                    2 => 5000,
                    3 => 7000,
                ],
            ],
        ],
    ],
];
