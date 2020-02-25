<?php

namespace App\Admin\Models;

use App\Models\Category as BaseCategory;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;

class Category extends BaseCategory
{
    use ModelTree, AdminBuilder;
}
