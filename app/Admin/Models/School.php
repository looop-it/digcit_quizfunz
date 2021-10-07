<?php

namespace App\Admin\Models;

use App\Models\School as BaseSchool;

class School extends BaseSchool
{
    public static $type = [
    ];

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
