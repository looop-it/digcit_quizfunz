<?php

namespace App\Admin\Extensions\Tools;

use App\Admin\Models\AdvType;
use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class AdvSelect extends AbstractTool
{
    protected function script()
    {
        $url = Request::fullUrlWithQuery(['type_id' => '_type_id_']);

        return <<<EOT

$('input:radio.adv-select').change(function () {

    var url = "$url".replace('_type_id_', $(this).val());

    $.pjax({container:'#pjax-container', url: url });

});

EOT;
    }

    public function render()
    {
        Admin::script($this->script());
        $options = AdvType::where('status',1)->pluck('title', 'id');
        // $options = [
        //     'all'   => 'All',
        //     'm'     => 'Male',
        //     'f'     => 'Female',
        // ];
        // dd($options);

        return view('admin.tools.advSelect', compact('options'));
    }
}