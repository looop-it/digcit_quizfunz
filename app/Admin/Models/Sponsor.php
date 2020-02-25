<?php

namespace App\Admin\Models;

use App\Models\Sponsor as BaseSponsor;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Sponsor extends BaseSponsor implements Sortable
{
    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];



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
