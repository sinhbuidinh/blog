<?php

function readJsonFile($path = '')
{
    if (empty($path) || !file_exists($path)) {
        return [];
    }
    $json = file_get_contents($path);
    $data = json_decode($json, true);
    return $data;
}

function code2Name(string $link)
{
    $config = config($link);
    if (empty($config)) {
        return [];
    }
    $codes = data_get($config, 'code');
    $names = data_get($config, 'name');
    if (count($codes) != count($names)) {
        return [];
    }
    return array_combine(array_values($codes), array_values($names));
}
function generateTraceMessage($exception) 
{
    $trace            = $exception->getTrace();
    $last_action_file = data_get($trace, '0.file');
    $last_action_line = data_get($trace, '0.line');
    $message          = $exception->getMessage();
    return $message.' at '.$last_action_file.':'.$last_action_line;
}
function genGuestCode($id)
{
    if (empty($id)) {
        return false;
    }
    return config('setting.guest_code').sprintf('%05d', $id);
}
function genParcelCode($id, $guest_code)
{
    if (empty($id)) {
        return false;
    }
    return config('setting.parcel_code').$guest_code.sprintf('%09d', $id);
}
function genPackageCode($id)
{
    if (empty($id)) {
        return false;
    }
    return config('setting.package_code').sprintf('%011d', $id);
}
function stringify2array($string)
{
    if (empty($string)) {
        return [];
    }
    return json_decode(html_entity_decode(stripslashes($string)), true);
}
function array_key_last($array)
{
    if (!is_array($array) || empty($array)) {
        return NULL;
    }
    return array_keys($array)[count($array)-1];
}
function formatPrice($price, $decimals = 2, $end = '')
{
    if ($price === '' || $price === null) {
        return '';
    }
    if (!is_numeric($price)) {
        $price = 0;
    }
    if (strpos($price, '.') === false) {
        return number_format($price).$end;
    }
    return number_format($price, $decimals).$end;
}
function removeFormatPrice($string)
{
    $string = str_replace(",", "", $string);
    return $string;
}
function getProvinceById($id)
{
    $provinces = readJsonFile(config_path('address/provincial.json'));
    return data_get($provinces, $id, []);
}
function getDistrictById($province, $id)
{
    $provinces = readJsonFile(config_path('address/district/'.$province.'.json'));
    return data_get($provinces, $id, []);
}
function getWardById($district, $id)
{
    $wards = readJsonFile(config_path('address/ward/'.$district.'.json'));
    return data_get($wards, $id, []);
}
function sqlPriceReal(string $field)
{
    return "REPLACE(IFNULL($field, 0), ',', '')";
}
function sqlNumberFormat(string $obj)
{
    return "FORMAT($obj, 0)";
}