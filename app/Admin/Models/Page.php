<?php

namespace App\Admin\Models;

use App\Models\Page as BasePage;

use Encore\Admin\Traits\ModelTree;
use Encore\Admin\Traits\AdminBuilder;

class Page extends BasePage
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
