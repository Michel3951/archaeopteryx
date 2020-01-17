<?php


namespace App\Classes\File;


use Carbon\Carbon;

class Directory
{
    public $path;

    public $files = [];

    public function __construct($path)
    {
        $this->path = $path;

        if (!file_exists($path)) return $this->files = null;

        $this->handle();
    }

    private function handle()
    {
        $items = new \DirectoryIterator($this->path);

        foreach ($items as $item) {
            if (!$item->isDot()) {
                array_push($this->files, [
                    'name' => $item->getBasename(),
                    'size' => $item->getSize(),
                    'date' => $item->getMTime(),
                    'dateAsString' => Carbon::parse($item->getMTime())->format('j M'),
                    'user' => $item->getOwner(),
                    'type' => $item->getType(),
                    'group' => $item->getGroup(),
                ]);
            }
        }
    }
}
