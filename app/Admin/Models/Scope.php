<?php

namespace App\Admin\Models;

use App\Models\Scope as BaseScope;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;

class Scope extends BaseScope
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
