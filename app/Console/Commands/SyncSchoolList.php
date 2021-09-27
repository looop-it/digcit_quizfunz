<?php

namespace App\Console\Commands;

use App\Jobs\SyncSchoolListFromCore;
use Illuminate\Console\Command;

class SyncSchoolList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'school:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync school list from core';

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
        dispatch(new SyncSchoolListFromCore);
    }
}
