<?php

namespace App\Admin\Models;

use App\Models\FeaturePost as BaseFeaturePost;

use Encore\Admin\Traits\ModelTree;
use Encore\Admin\Traits\AdminBuilder;

class FeaturePost extends BaseFeaturePost
{
    use ModelTree, AdminBuilder;
}
