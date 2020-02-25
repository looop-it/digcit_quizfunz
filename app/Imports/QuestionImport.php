<?php

namespace App\Imports;

use App\Models\Question;
use Maatwebsite\Excel\Concerns\ToModel;

class QuestionImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // return new Question([
        //     //
        // ]);
    }

    // public function batchSize(): int
    // {
    //     return 1000;
    // }
}
