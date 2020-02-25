<?php

namespace App\Admin\Extensions;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Tools\BatchAction;

class RestoreButton extends BatchAction
{
    protected $id;
    protected $action;

    public function __construct($id, $action = 1)
    {
        $this->id = $id;
        $this->action = $action;
    }

    public function script()
    {
        return <<<SCRIPT

$('.grid-check-row').on('click', function () {

    // Your code.
    $.ajax({
        method: 'post',
        url: '/admin/trashed-posts/restore',
        data: {
            _token:'{$this->getToken()}',
            ids: {$this->id},
        },
        success: function () {
            $.pjax.reload('#pjax-container');
            toastr.success('Success');
        }
    });

});

SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());

        return "<a class='btn btn-xs btn-success fa fa-check grid-check-row' data-id='{$this->id}'></a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}
