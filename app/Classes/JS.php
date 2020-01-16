<?php


namespace App\Classes;


class JS
{
    public static function JSON_parse($value)
    {
       return str_replace("&quot;", '"', json_encode($value));
    }
}
