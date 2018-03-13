<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Diablo3\Api;

class GetTokenCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:getToken';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'diablo3 api getToken';

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

        //$this->info('1234');
        $api->getToken();
    }
}
