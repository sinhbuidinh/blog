<?php

return [
    'pager' => [
        'common_limit' => 10
    ],
    'guest_code' => 'KH',
    'default' => [
        'vat' => 10,
        'support_gas' => 20,
        'support_remote' => 20
    ],
    'parcel_type' => [
        'code' => [
            'package' => 1,
            'document' => 2,
        ],
        'name' => [
            'package' => 'Hàng Hóa',
            'document' => 'Tài Liệu',
        ],
    ],
    'transfer_type' => [
        'code' => [
            'quick' => 1,
            'transport' => 2,
        ],
        'name' => [
            'quick' => 'Chuyển phát nhanh',
            'transport' => 'Vận tải',
        ],
    ],
];