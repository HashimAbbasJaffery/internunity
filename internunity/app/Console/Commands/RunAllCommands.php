<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunAllCommands extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run all required commands to start the project';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting PHP server...');
        exec('php artisan serve');
        $this->info("Starting Listener");
        exec('php artisan queue:listen');
        $this->info("Start Reverb");
        exec("php artisan reverb:start");
    }
}
