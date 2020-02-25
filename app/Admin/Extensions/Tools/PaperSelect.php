<?php

namespace App\Admin\Extensions\Tools;

use App\Admin\Models\Feature;
use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class PaperSelect extends AbstractTool
{
    protected function script()
    {
        $url = Request::fullUrlWithQuery(['status' => '_status_']);

        return <<<EOT

$('input:radio.promo-select').change(function () {

    var url = "$url".replace('_status_', $(this).val());

    $.pjax({container:'#pjax-container', url: url });

});

EOT;
    }

    public function render()
    {
        Admin::script($this->script());
        $options = [
                    'creating'   => '生成中',
                    'created'    => '已生成',
                    'assigned'   => '已分配',
                    'processing' => '答題中',
                    'reviewing'  => '評分中',
                    'finished'   => '已答題',
                    'canceled'   => '已取消',
                    'voided'     => '已作廢',
                    ];
        // $options = [
        //     'all'   => 'All',
        //     'm'     => 'Male',
        //     'f'     => 'Female',
        // ];
        // dd($options);

        return view('admin.tools.paperSelect', compact('options'));
    }
}
