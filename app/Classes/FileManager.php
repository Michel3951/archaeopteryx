<?php


namespace App\Classes;


class FileManager
{
    /**
     * The name of the file
     * @var $filename
     */

    public $filename;

    /**
     * The path to the file
     * @var $path
     */

    public $path;

    /**
     * The content of the file
     * @var $content
     */

    public $content;

    public static function createFile($path, $filename)
    {
        file_put_contents($path . $filename, '');
        return $path . $filename;
    }

    public static function createDirectory($path, $dirname)
    {
        mkdir($path . $dirname);
    }
}
