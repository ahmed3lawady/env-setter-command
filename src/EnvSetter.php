<?php

namespace Ahmed3lawady\EnvSetter;

use Illuminate\Console\Command;

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
        $envPath = app()->environmentPath().'/.env';
        if (!\File::exists($envPath)){
            \File::copy(app()->environmentPath().'/.env.example', $envPath);
        }

        $envContent = file_get_contents($envPath);
        preg_match('/^'.$this->argument('key').'[^\r\n]*/m', $envContent, $line);
        $newLine = $this->argument('key').'='.$this->argument('value');
        $set = file_put_contents($envPath, str_replace($line[0], $newLine, $envContent));
        echo ($set) ?
            $this->argument('key')." value has been updated.\n" :
            "Error, ".$this->argument('key')." value doesn't changed!\n";
    }
}