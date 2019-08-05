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