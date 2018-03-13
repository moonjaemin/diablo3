<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Diablo3\Api;

class CurrentIndexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:currentIndex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'diablo3 api current index';

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
    public function handle(Api $api)
    {
        //
        $api->setCurrentIndex();
    }
}
