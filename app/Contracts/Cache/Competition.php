<?php

namespace App\Contracts\Cache;

use App\Models\Paper;

interface Competition
{
    // Paper cache
    public function setPaper(Paper $paper);

    public function getPaper();

    public function clearPaper();

    // Answer cache
    public function setAnswer(array $data);
    
    public function isAnswerExists();
    
    public function getAnswer();

    public function getQuestionDetail($index);

    public function clearAnswer();
}
