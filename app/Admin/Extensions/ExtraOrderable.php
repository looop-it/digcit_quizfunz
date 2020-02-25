<?php

namespace App\Admin\Extensions;

use Encore\Admin\Admin;
use Request;

class ExtraOrderable
{
    protected $id;
    protected $action;

    public function __construct($id, $action = 1)
    {
        $this->id = $id;
        $this->action = $action;
        $this->url = Request::url();
    }

    protected function script()
    {
        return <<<EOT

$('.grid-row-extra-orderable').on('click', function() {

    var key = $(this).data('id');
    var direction = $(this).data('direction');

    $.post('{$this->url}/extraOrderable/' + key, {_method:'POST', _token:LA.token, _orderable:direction}, function(data){
        if (data.status) {
            $.pjax.reload('#pjax-container');
            toastr.success(data.message);
        }
    });
});
EOT;
    }

    protected function render()
    {
        Admin::script($this->script());

        return <<<EOT

<div class="btn-group">
    <button type="button" class="btn btn-xs btn-info grid-row-extra-orderable" data-id="{$this->id}" data-direction="99">
        <i class="fa fa-angle-double-up fa-fw"></i>
    </button>
    <button type="button" class="btn btn-xs btn-default grid-row-extra-orderable" data-id="{$this->id}" data-direction="-1">
        <i class="fa fa-angle-double-down fa-fw"></i>
    </button>
</div>

EOT;
    }

    public function __toString()
    {
        return $this->render();
    }
}
