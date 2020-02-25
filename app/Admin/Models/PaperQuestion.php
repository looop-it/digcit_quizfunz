<?php

namespace App\Admin\Models;

use App\Models\PaperQuestion as BasePaperQuestion;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;

class PaperQuestion extends BasePaperQuestion
{
    use ModelTree, AdminBuilder;

    public static function boot()
    {
        parent::boot();

        // Generate fix answers when creating paper question record
        static::creating(function (PaperQuestion $paper_question) {
            $paper_question->answers = $paper_question->generateAnswers();
        });
    }

    public function generateAnswers()
    {
        return $this->question->answers()->inRandomOrder()->pluck('correct', 'content');
    }

    public static function judge(PaperQuestion $pq)
    {
        $correct = false;
        $pqa = $pq->answers;
        if (isset($pq->result) && is_array($pq->result)) {
            foreach ($pq->result as $value) {
                if ($pqa[$value]) {
                    $correct = true;
                } else {
                    $correct = false;
                }
            }
        }
        return $correct;
    }
}
