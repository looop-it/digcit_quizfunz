<?php

namespace App\Admin\Models;

use App\Models\Season as BaseSeason;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;

class Season extends BaseSeason
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
