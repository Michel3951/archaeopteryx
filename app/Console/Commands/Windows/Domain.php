<?php

namespace App\Console\Commands\Windows;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class Domain extends Command
{
    protected $signature = 'windows:domain {name : The domain name} {--preset= : Preset to use, optional} {--type= : The type of the project} {--no-host : Dont create a virtual host}';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    private $root = 'C:/xampp/htdocs';

    /**
     * Create the directory for this domain
     */
    public function handle()
    {
        $arguments = $this->arguments();
        $options = $this->options();

        $domain = $arguments['name'];
        $errors = [];

        $exists = new Process(['dir', "{$this->root}/${domain}"]);
        $exists->run();

        if (!$exists->isSuccessful()) {
            $message = $exists->getErrorOutput();
            if (substr($message, 0, 14) === 'File Not Found') {
                $mkdir = new Process(['mkdir', 'C:/xampp/htdocs/' . $domain]);
                $mkdir->run();
            }
        }

        $path = "{$this->root}/$domain";

        $type = 'plain';

        if (array_key_exists('type', $options)) {
            switch ($options['type']) {
                case 0:
                    $type = 'plain';
                    break;
                case 1:
                    $type = 'laravel';
            }
        }

        if (array_key_exists('preset', $options)) {
            $copy = Process::fromShellCommandline("xcopy \"" . str_replace("\\", "/", $options['preset']) . "\" \"$path\" /s /e /h");
            $copy->run();
            $copy->getOutput();
        }

        if (!array_key_exists('no-host', $options)) {
            $append = new Process(['echo', "127.0.0.1 {$domain}", '>>', 'C:\Windows\System32\drivers\etc\hosts']);
            $append->run();
            if (!$append->isSuccessful()) {
                print $append->getErrorOutput();
            }
        }

        return [
            'root' => $path,
            'type' => (int) $type,
            'domain' => $domain
        ];
    }
}
