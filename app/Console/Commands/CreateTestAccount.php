<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Participant;
use App\Models\School;

class CreateTestAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {number?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create test accounts.';

    /**
     * Create a new command instance.
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
        if (config('app.env') == 'production') {
            return $this->error('Fatal: this command only work in local or testing environment.');
        }

        $number = $this->argument('number');

        if (!$number) {
            $number = $this->ask('How many test accounts do you want to generate?', 50);
        }

        $startId = $this->ask('Account start ID?');

        // Get demo account id

        for ($i = 0; $i < $number; ++$i) {
            $user = factory(User::class)->create([
                'email' => "demo{$startId}@looop.hk",
                'password' => bcrypt('secret'),
                'source' => 'quizfunz',
                'verified' => true,
            ]);

            // create participant
            factory(Participant::class)->create([
                'user_id' => $user->id,
                'school_id' => School::inRandomOrder()->first()->id,
            ]);

            ++$startId;
        }
    }
}
