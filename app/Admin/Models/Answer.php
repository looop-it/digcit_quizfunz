<?php

namespace App\Admin\Models;

use App\Models\Answer as BaseAnswer;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;

class Answer extends BaseAnswer
{
    use ModelTree, AdminBuilder;

}
