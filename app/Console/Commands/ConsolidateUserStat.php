<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\User;
use App\Jobs\StoreUserStatFromCache;

class ConsolidateUserStat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consolidate:user-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store user stats from cache to database';

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
        $users = User::competition()->get();

        if (count($users) > 0) {
            foreach ($users as $user) {
                dispatch(new StoreUserStatFromCache($user));
            }
        }
    }
}
