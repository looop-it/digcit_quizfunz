<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Paper;
use Illuminate\Support\Facades\DB;
use App\Jobs\Competition\JudgePaperQuestions;

class PaperReJudge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paper:re-judge {paper?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-judge paper';

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
        $paperId = $this->argument('paper');
        
        if ($paperId) {
            $papers = Paper::where('id', $paperId)->get();
        } else {
            $papers = Paper::whereStatus('finished')->get();
        }

        foreach ($papers as $paper) {
            try {
                DB::transaction(function () use ($paper) {
                    $paper->update([
                        'status' => 'reviewing'
                    ]);
                }, 5);
            } catch (\Exception $exception) {
                \Log::error("Failed to update paper status from finished to reviewing. Paper ID: {$paper->id}");

                return;
            }
           

            dispatch(new JudgePaperQuestions($paper));
        }
    }
}
