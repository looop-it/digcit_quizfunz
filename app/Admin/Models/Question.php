<?php

namespace App\Admin\Models;

use App\Models\Question as BaseQuestion;
use Illuminate\Http\Request;
use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Encore\Admin\Form;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\MessageBag;
use Encore\Admin\Layout\Content;

class Question extends BaseQuestion
{
    use ModelTree, AdminBuilder;

    /**
     * @return bool|null
     * @throws \Exception
     *
     * 重寫
     */
    public function delete()
    {
        $this->where($this->primaryKey, $this->getKey())->delete();

        return parent::delete();
    }
}
