<?php

namespace App\Admin\Extensions\Tools;

use App\Admin\Models\Feature;
use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\AbstractTool;
use Illuminate\Support\Facades\Request;

class PromoSelect extends AbstractTool
{
    protected function script()
    {
        $url = Request::fullUrlWithQuery(['feature_id' => '_feature_id_']);

        return <<<EOT

$('input:radio.promo-select').change(function () {

    var url = "$url".replace('_feature_id_', $(this).val());

    $.pjax({container:'#pjax-container', url: url });

});

EOT;
    }

    public function render()
    {
        Admin::script($this->script());
        $options = Feature::where('status',1)->pluck('title', 'id');
        // $options = [
        //     'all'   => 'All',
        //     'm'     => 'Male',
        //     'f'     => 'Female',
        // ];
        // dd($options);

        return view('admin.tools.promoSelect', compact('options'));
    }
}