<?php

namespace App\Admin\Models;

use App\Models\School as BaseSchool;
use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;

class School extends BaseSchool
{
    const TYPE_SECONDARY = 'secondary';
    const TYPE_UNIVERSITY = 'university';

    public static $type = [
        self::TYPE_SECONDARY => '中學',
        self::TYPE_UNIVERSITY => '大學',
    ];

    use ModelTree, AdminBuilder;

    /**
     * @return bool|null
     *
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
