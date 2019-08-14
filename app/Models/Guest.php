<?php

namespace App\Models;

class Guest extends BaseModel
{
    const STATUS_ENABLE        = 1;
    const STATUS_DISABLE       = 0;
    const STATUS_NAME_ENABLE   = 'enable';
    const STATUS_NAME_DISABLE  = 'disable';
    static $statusNames = [
        self::STATUS_ENABLE  => self::STATUS_NAME_ENABLE,
        self::STATUS_DISABLE => self::STATUS_NAME_DISABLE,
    ];

    protected $append = ['province_name', 'district_name', 'ward_name'];
    protected $fillable = [
        'representative', 'represent_tel', 'represent_email', 'company_name', 'email', 'tel', 'fax', 'tax_code', 'tax_address', 'provincial', 'district', 'ward', 'address', 'guest_code', 'price_table', 'discount', 'status'
    ];

    public function getProvinceNameAttribute()
    {
        $provincial = getProvinceById($this->provincial);
        return data_get($provincial, 'name_with_type');
    }

    public function getDistrictNameAttribute()
    {
        $district = getDistrictById($this->provincial, $this->district);
        return data_get($district, 'name_with_type');
    }

    public function getWardNameAttribute()
    {
        $ward = getWardById($this->district, $this->ward);
        return data_get($ward, 'name_with_type');
    }

    public static function getDistricts($province)
    {
        if (empty($province)) {
            return [];
        }
        $fileName = sprintf('%02d', $province);
        $path = config_path('address/district/'.$fileName.'.json');
        $districts = readJsonFile($path);
        if (empty($districts)) {
            return $districts;
        }
        $sorted = array_sort($districts, function($value) {
            return $value['code'];
        });
        return $sorted;
    }

    public static function getWards($district)
    {
        if (empty($district)) {
            return [];
        }
        $fileName = sprintf('%03d', $district);
        $path = config_path('address/ward/'.$fileName.'.json');
        $wards = readJsonFile($path);
        if (empty($wards)) {
            return $wards;
        }
        $sorted = array_sort($wards, function($value) {
            return $value['code'];
        });
        return $sorted;
    }
}