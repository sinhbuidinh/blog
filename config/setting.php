<?php

return [
    'pager' => [
        'common_limit' => 10
    ],
    'guest_code' => 'KH',
    'parcel_code' => 'BP',
    'package_code' => 'PACK',
    'company_location' => 'Quận 11, Hồ Chí Minh',
    'company_transfer_location' => 'Quận 5, Hồ Chí Minh',
    'transport_agent' => [
        'code' => [
            'inside'    => 1,
            '247agency' => 2,
            'spedex'    => 3,
            'tuyenphat' => 4,
        ],
        'name' => [
            'inside'    => 'Nội bộ',
            '247agency' => 'Đại lý 247',
            'spedex'    => 'Spedex',
            'tuyenphat' => 'Tuyến Phát',
        ],
    ],
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