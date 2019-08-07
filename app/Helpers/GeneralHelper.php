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