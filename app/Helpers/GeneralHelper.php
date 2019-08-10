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
    return config('setting.guest_code').sprintf('%03d', $id);
}
function stringify2array($string)
{
    if (empty($string)) {
        return [];
    }
    return json_decode(html_entity_decode(stripslashes($string)), true);
}