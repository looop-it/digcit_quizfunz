<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Paper;
use App\Models\Participant;

class PaperVoid extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'paper:void 
                            {paper? : The ID of paper}
                            {--bulk : Bulk void exceed limit papers}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Void a paper.';

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
        $isBulk = $this->option('bulk');

        if ($isBulk) {
            $season = season();

            $participants = Participant::withCount(['papers' => function ($query) use ($season) {
                $query->where('season_id', $season->id)
                    ->where('status', 'finished');
            }])
            ->having('papers_count', '>', $season->times_limit)
            ->get();
            
            foreach ($participants as $participant) {
                $paper = $participant->papers()
                                    ->inSeason($season->id)
                                    ->finished()
                                    ->orderBy('started_at', 'asc')
                                    ->offset($season->times_limit)
                                    ->first();
                
                $this->void($paper);
            }
        } else {
            $paperId = $this->argument('paper');

            if (!$paperId) {
                $paperId = $this->ask('Which paper id do you want to void?');
            }

            $paper = Paper::finished()->where('id', intval($paperId))->first();

            if (!$paper) {
                $this->error('Cannot find finished paper with the provided ID.');

                return;
            }
            
            if ($this->confirm("You are going to void a paper ID {$paperId}, Sure?")) {
                $this->void($paper);
            }
        }
    }

    private function void(Paper $paper)
    {
        try {
            $paper->update([
                'status' => 'voided'
            ]);
        } catch (\Exception $exception) {
            \Log::error("Failed to voided paper. Paper ID: {$paper->id}. Error: {$exception->getMessage()}");
        }
    }
}
