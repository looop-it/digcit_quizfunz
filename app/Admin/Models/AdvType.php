<?php

namespace App\Admin\Models;

use App\Models\AdvType as BaseAdvType;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;

class AdvType extends BaseAdvType
{
    use ModelTree, AdminBuilder;
}
