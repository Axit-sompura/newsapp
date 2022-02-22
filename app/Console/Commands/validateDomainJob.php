<?php

namespace App\Console\Commands;

use App\Jobs\ValidateDomain;
use Illuminate\Console\Command;

class validateDomainJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'validate:domain';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        ValidateDomain::dispatch()->onQueue('default');
    }
}
