<?php

namespace App\Admin\Models;

use App\Models\CompetitionInfo as BaseCompetitionInfo;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;

class CompetitionInfo extends BaseCompetitionInfo
{
    use ModelTree, AdminBuilder;
}
