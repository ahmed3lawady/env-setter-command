<?php

namespace Ahmed3lawady\EnvSetter;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class EnvSetter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'env:set {key} {value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make environment file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!file_exists(app()->environmentFilePath())){
            Storage::copy(app()->environmentPath().'/.env.example', app()->environmentFilePath());
        }

        $envContent = file_get_contents(app()->environmentFilePath());
        preg_match('/^' . $this->argument('key') . '[^\r\n]*/m', $envContent, $line);
        $newLine = $this->argument('key') . '=' . $this->argument('value');

        if (count($line)){
            $set = file_put_contents(app()->environmentFilePath(), str_replace($line[0], $newLine, $envContent));
        } else {
            $set = file_put_contents(app()->environmentFilePath(), "\n\n" . $newLine, FILE_APPEND);
        }

        echo ($set) ?
            $this->argument('key')." value has been updated.\n" :
            "Error, ".$this->argument('key')." value doesn't changed!\n";
    }
}