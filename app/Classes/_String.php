<?php


namespace App\Classes;


class _String
{
    public static function startsWith(string $needle, string $haystack)
    {
        $pitchfork = substr($haystack, 0, strlen($needle));
        return $pitchfork === $needle;
    }

    public static function endsWith(string $needle, string $haystack)
    {
        $pitchfork = substr($haystack, strlen($haystack) - strlen($needle), strlen($needle));
        return $pitchfork === $needle;
    }
}
