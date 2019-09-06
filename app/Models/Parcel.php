<?php

namespace App\Models;

class Parcel extends BaseModel
{
    const TYPE_TINH     = 'tinh';
    const TYPE_THANHPHO = 'thanh-pho';
    const TYPE_THIXA    = 'thi-xa';
    const TYPE_QUAN     = 'quan';
    const TYPE_HUYEN    = 'huyen';
    const TYPE_THITRAN  = 'thi-tran';
    const TYPE_PHUONG   = 'phuong';
    const TYPE_XA       = 'xa';
    // 0:deleted, 1:init, 2:package, 3:transfer, 4:refund, 5:forward, 6:complete
    const STATUS_DELETED        = 0;
    const STATUS_INIT           = 1;
    const STATUS_INPACKAGE      = 2;
    const STATUS_TRANSFER       = 3;
    const STATUS_REFUND         = 4;
    const STATUS_FORWARD        = 5;
    const STATUS_COMPLETE       = 6;
    const STATUS_DELETED_NAME   = 'Đã xóa';
    const STATUS_INIT_NAME      = 'Nhập hệ thống';
    const STATUS_INPACKAGE_NAME = 'Đã đóng bảng kê';
    const STATUS_TRANSFER_NAME  = 'Đang chuyển';
    const STATUS_REFUND_NAME    = 'Chuyển hoàn';
    const STATUS_FORWARD_NAME   = 'Chuyển tiếp';
    const STATUS_COMPLETE_NAME  = 'Đã phát';
    static $statusNames = [
        self::STATUS_DELETED   => self::STATUS_DELETED_NAME,
        self::STATUS_INIT      => self::STATUS_INIT_NAME,
        self::STATUS_INPACKAGE => self::STATUS_INPACKAGE_NAME,
        self::STATUS_TRANSFER  => self::STATUS_TRANSFER_NAME,
        self::STATUS_REFUND    => self::STATUS_REFUND_NAME,
        self::STATUS_FORWARD   => self::STATUS_FORWARD_NAME,
        self::STATUS_COMPLETE  => self::STATUS_COMPLETE_NAME,
    ];

    protected $fillable = [
        'guest_id', 'guest_code', 'bill_code', 'parcel_code', 'type', 'real_weight', 'weight', 'long', 'wide', 'height', 'num_package', 'type_transfer', 'services', 'total_service', 'time_input', 'time_receive', 'receiver', 'receiver_tel', 'receiver_company', 'value_declare', 'provincial', 'district', 'ward', 'address', 'price', 'cod', 'vat', 'price_vat', 'refund', 'forward', 'support_gas', 'support_remote', 'total', 'status', 'note', 'agency'
    ];

    public function transfered()
    {
        return $this->hasMany('App\Models\Transfered', 'parcel_id', 'id');
    }

    public function guest()
    {
        return $this->belongsTo('App\Models\Guest');
    }

    public function getStatusNameAttribute()
    {
        //status
        return data_get(self::$statusNames, $this->status);
    }

    public function getDateReceiveAttribute()
    {
        return date("Y-m-d", strtotime($this->time_receive));
    }

    public function getTypeNameAttribute()
    {
        $list = config('setting.parcel_type');
        $code = array_search($this->type, $list['code']);
        if ($code === false) {
            return '';
        }
        return data_get($list['name'], $code);
    }

    public function getTransferNameAttribute()
    {
        $list = config('setting.transfer_type');
        $code = array_search($this->type_transfer, $list['code']);
        if ($code === false) {
            return '';
        }
        return data_get($list['name'], $code);
    }

    public function getIsReadyTransferAttribute()
    {
        if ($this->status == self::STATUS_INPACKAGE) {
            return true;
        }
        return false;
    }

    public function getReadyCompleteAttribute()
    {
        if ($this->status == self::STATUS_TRANSFER 
            || $this->status == self::STATUS_REFUND
            || $this->status == self::STATUS_FORWARD
        ) {
            return true;
        }
        return false;
    }

    public function getServicesDisplayAttribute()
    {
        $services = stringify2array($this->services);
        $names = array_pluck($services, 'name') ?: [];
        return implode(', ', $names);
    }

    public function getReceiverSignatureAttribute()
    {
        //transfered -> complete_receiverd
        return data_get($this->transfered()->first(), 'complete_receiver');
    }

    public function getCompanyNameAttribute()
    {
        //company_name
        return data_get($this->guest()->first(), 'company_name');
    }

    public function getGuestAddressAttribute()
    {
        //company address
        return data_get($this->guest()->first(), 'address');
    }

    public function getReceiveDateAttribute()
    {
        //company address
        return date('Y-m-d', strtotime($this->time_receive));
    }

    public function getProvinceNameAttribute()
    {
        $provincial = getProvinceById($this->provincial);
        return data_get($provincial, 'name');
    }

    public function forwardAndRefund($format = true)
    {
        $total = removeFormatPrice($this->forward) + removeFormatPrice($this->refund);
        if ($format == true) {
            return formatPrice($total);
        }
        return $total;
    }

    public function totalServicePrice($format = true)
    {
        $total = removeFormatPrice($this->total_service);
        if ($format == true) {
            return formatPrice($total);
        }
        return $total;
    }

    public function remoteAndOther($format = true)
    {
        $total = removeFormatPrice($this->support_remote);
        if ($format == true) {
            return formatPrice($total);
        }
        return $total;
    }

    public function gasAndVat($format = true)
    {
        $total = removeFormatPrice($this->support_gas) + removeFormatPrice($this->price_vat);
        if ($format == true) {
            return formatPrice($total);
        }
        return $total;
    }

    public function getHistoryStatusNameAttribute()
    {
        $name = data_get(self::$statusNames, $this->history_status);
        if (($this->history_status == self::STATUS_REFUND
            || $this->history_status == self::STATUS_FORWARD)
            && !empty($this->history_note)
        ) {
            return $name . ': '. $this->history_note;
        }
        return $name;
    }

    public function getImgTrackAttribute()
    {
        return ($this->history_status == self::STATUS_COMPLETE) ? 'images/checked_25.png' : 'images/checked.png';
    }

    public function getAgencyNameAttribute()
    {
        $agency = config('setting.transport_agent');
        $pos = array_search($this->agency, data_get($agency, 'code'));
        if ($pos === false || empty($agency['name'])) {
            return '';
        }
        return data_get($agency['name'], $pos);
    }

    public function getParcelDisplayForPackageAttribute()
    {
        return ($this->bill_code) ? $this->bill_code : $this->parcel_code;
    }

    public function history() 
    {
        return $this->hasMany('App\Models\ParcelHistory', 'parcel_id', 'id');
    }

    public static function isCalRemote($province, $district)
    {
        if (empty($province) || empty($district)) {
            return false;
        }
        //is Noi chung thanh pho thuoc tinh la gia binh thuong
        // Con ve huyen va xa thuoc tinh thanh la cong phu phi vung sau vung xa
        $province_info = getProvinceById($province);
        $district_info = getDistrictById($province, $district);
        $province_type = data_get($province_info, 'type');
        $district_type = data_get($district_info, 'type');
        // dd($province_type, $district_type, self::TYPE_TINH, self::TYPE_HUYEN, self::TYPE_THIXA);
        if ($province_type == self::TYPE_TINH
            && $district_type == self::TYPE_THANHPHO
        ) {
            return false;
        }
        if ($province_type == self::TYPE_TINH
            && (
                $district_type == self::TYPE_HUYEN
                || $district_type == self::TYPE_THIXA
            )
        ) {
            return true;
        }
        return false;
    }
}