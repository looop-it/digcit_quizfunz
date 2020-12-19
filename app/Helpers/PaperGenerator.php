<?php

namespace App\Helpers;

use App\Models\QuestionCategory;
use App\Models\Scope;
use Illuminate\Support\Collection;
use App\Models\Season;

class PaperGenerator
{
    public function __construct()
    {
        $this->categories = questionCategory();
        $this->scopes = questionScope();
    }

    public function setSeason(Season $season)
    {
        $this->season = $season;

        return $this;
    }

    public function generate()
    {
        do {
            $questions = collect([]);

            // Get questions from generate category.
            $questions = $questions->merge(
                $this->getQuestionsInCategory(
                    'general',
                    $this->season->general_questions
                )
            );

            // $questions = $questions->merge(
            //     $this->getQuestionsInScope(
            //         1,
            //         10
            //     )
            // );

            // $questions = $questions->merge(
            //     $this->getQuestionsInScope(
            //         2,
            //         10
            //     )
            // )->shuffle();
            
            // Get question from 9+2 category.
            // $questions = $questions->merge(
            //     $this->getQuestionsInCategory(
            //         'other',
            //         $this->season->other_questions
            //     )
            // );

            $difficulty = $this->getDifficulty($questions);
        } while (! $this->isDifficultyInRange($difficulty));

        return [
            'difficulty' => $difficulty,
            'questions' => $questions
        ];
    }
    
    private function getQuestionsInCategory($targetCategory, $quantity)
    {
        $questions = collect([]);

        $this->categories->filter(function ($category) use ($targetCategory) {
            // TODO: Enhancement needed. 1 = generate category is not a safe way.
            if ($targetCategory == 'general') {
                return $category->id == 1;
            }

            return $category->id != 1;
        })->each(function ($category) use (& $questions, $quantity) {
            $questions = $questions->merge($this->getQuestions($category, $quantity));
        });

        return $questions;
    }

    private function getQuestionsInScope($targetScope, $quantity)
    {
        $questions = collect([]);

        $this->scopes->filter(function ($scope) use ($targetScope) {
            return $scope->id == $targetScope;
        })->each(function ($scope) use (& $questions, $quantity) {
            $questions = $questions->merge($this->getQuestions($scope, $quantity));
        });

        return $questions;
    }

    /**
     * Randomly get number of questions in category.
     *
     * @param \App\Models\QuestionCategory $category
     * @param integer $quantity
     * @return \Illuminate\Support\Collection
     */
    private function getQuestions(Scope $scope, int $quantity) : Collection
    {
        return $scope->questions()
                        ->enabled()
                        ->inRandomOrder()
                        ->take($quantity)
                        ->get();
    }

    /**
     * Get difficulty of all questions generated.
     *
     * @param \Illuminate\Support\Collection $questions
     * @return void
     */
    public function getDifficulty(Collection $questions)
    {
        return $questions->pluck('level')->reduce(function ($carry, $item) {
            return $carry + $item;
        });
    }

    /**
     * Check if the difficulty of the generated paper is in the defined range.
     *
     * @param integer $difficulty
     * @return boolean
     */
    private function isDifficultyInRange(int $difficulty) : bool
    {
        $minDifficulty = intval($this->season->difficulty) - intval($this->season->difficulty_offset);
        $maxDifficulty = intval($this->season->difficulty) + intval($this->season->difficulty_offset);
        
        if ($difficulty >= $minDifficulty && $difficulty <= $maxDifficulty) {
            return true;
        }

        return false;
    }
}
