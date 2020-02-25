<?php

namespace App\Admin\Models;

use App\Models\School as BaseSchool;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;

class School extends BaseSchool
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