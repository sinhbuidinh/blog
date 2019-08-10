<?php

return [
    'list' => [
        'transfer_guarantee' => [
            'value' => 0.02,
            'math' => '*',
            'display' => '2%',
            'atleast' => 100000,
            'limit' => 100000000,
            'name' => 'DV Bảo hiểm vận chuyển',
            'note' => 'Phí bảo hiểm tối thiểu 100,000 đồng/bill. Giá trị khai tối đa 100,000,000 đồng/bill',
        ],
        'cod_parcel' => [
            'value' => 0.02,
            'math' => '*',
            'display' => '2%',
            'target' => 'cod',
            'atleast' => 15000,
            'name' => 'DV Thu hộ',
            'note' => 'Tối thiểu 15,000 đồng/bill',
        ],
        'full_name' => [
            'value' => 5000,
            'display' => '5,000 đồng/bill',
            'note' => 'Cung cấp họ và tên người nhận',
            'name' => 'DV Thông tin đầy đủ',
        ],
        'bao_phat' => [
            'value' => 5000,
            'display' => '5,000 đồng/bill',
            'name' => 'DV Báo phát',
        ],
        'hand_delivery' => [
            'value' => 10000,
            'display' => '10,000 đồng/bill',
            'name' => 'DV Phát tận tay',
        ],
        'info_receive' => [
            'value' => 10000,
            'display' => '10,000 đồng/bill',
            'name' => 'DV Lấy số CMND/Căn cước người nhận',
        ],
        'sync_check' => [
            'value' => 1000,
            'display' => '1,000 đồng/đơn vị kiểm',
            'name' => 'DV Đồng kiểm',
            'atleast' => 100000,
            'note' => 'Tối thiểu 100,000 đồng/bill',
        ],
        'guest_secretary' => [
            'value' => 50000,
            'display' => '50,000 đồng/bill',
            'name' => 'DV Thư ký khách hàng',
            'note' => 'Chỉ áp dụng cho chứng từ',
        ],
        'pay_when_received' => [
            'value' => 20000,
            'display' => '20,000 đồng/bill',
            'name' => 'DV Thanh toán đầu nhận',
        ],
        'catalogue' => [
            'value' => 200000,
            'display' => '200,000 đồng/bill',
            'name' => 'DV Hồ sơ thầu',
            'note' => '+ 15,000 đồng/kg cho kg tiếp theo trên 2 kg',
            'append_more' => [
                'operator' => '>',
                'compare' => 2,
                'value' => 15000,
            ],
        ],
        'express' => [
            'value' => 10000,
            'display' => '10,000 đồng/kg',
            'name' => 'DV Hàng Express',
            'note' => 'Áp dụng cho vận đơn > 2kg',
            'require' => [
                'weight' => '> 2',
            ],
        ],
        'priority' => [
            'name' => 'DV Phát ưu tiên',
            'value' => 30000,
            'display' => '30,000 đồng/bill',
        ],
        'out_hourswork' => [
            'name' => 'DV Ngoài giờ hành chánh',
            'value' => 200000,
            'display' => '200,000 đồng/bill',
            'note' => 'Ngoài giờ hành chánh, Chủ Nhật, Ngày nghỉ',
        ],
        'freeze' => [
            'name' => 'DV Hàng đông lạnh',
            'value' => 15000,
            'display' => '15,000 đồng/kg',
            'note' => 'Hàng đông lạnh đi chuyến Express thì không cộng thêm phí Hàng nặng phát nhanh(not yet)',
        ],
        'security' => [
            'name' => 'Phí An Ninh',
            'value' => 12000,
            'display' => '12,000 đồng/kg',
            'atleast' => 250000,
            'note' => 'Tối thiểu 250,000 đồng/bill',
        ],
        'one_shield' => [
            'name' => 'DV Hàng nguyên khối',
            'value' => 0.2,
            'math' => '*',
            'display' => '20% cước chính',
            'note' => 'Tối thiểu 200,000 đồng/bill',
            'atleast' => 200000,
        ],
        'out_box' => [
            'name' => 'DV Hàng quá khổ',
            'value' => 0.2,
            'math' => '*',
            'display' => '20% cước chính',
            'require' => [
                'weight' => '> 30',
            ],
            'note' => 'Nếu kiện hàng có trọng lượng lớn hơn 30kg',
        ],
        'call_flower' => [
            'name' => 'DV Điện hoa',
            'value' => 200000,
            'display' => '200,000 đồng/bill',
            'note' => 'Chưa tính tiền mua hoa',
        ],
        'bill_finance' => [
            'name' => 'Hóa đơn tài chính',
            'value' => 20000,
            'display' => '20,000 đồng/bill',
        ],
        'receive_parcel_node' => [
            'name' => 'Nhận hộ vận đơn tại tuyến phát',
            'value' => 50000,
            'display' => '50,000 đồng/bill',
            'note' => 'Nếu nhận ngoài giờ hành chánh/nhận ngoài tuyến thì phải cộng thêm phí tương ứng',
        ],
    ],
];
