<?php

use Illuminate\Support\Facades\Log;

function helperTest()
{
    echo "oky";
}

function arrayToString($array, $string = '') {
    $array = (array) $array;
    foreach ($array as $key => $value) {
        if(is_array($value)) {
            $string = arrayToString($value, $string);
        }
        elseif(is_string($value) && !empty($value) && $value != ':message') {
            $string .= $value."\n";
        }
    }
    return $string;
}