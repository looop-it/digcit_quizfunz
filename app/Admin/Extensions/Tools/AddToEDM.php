<?php

namespace App\Admin\Extensions\Tools;

use Encore\Admin\Grid\Tools\BatchAction;

class AddToEDM extends BatchAction
{
    protected $action;

    public function __construct($action = 1)
    {
        $this->action = $action;
    }
    
    public function script()
    {
        return <<<EOT
        
// $('{$this->getElementClass()}').on('click', function() {
$('{$this->getElementClass()}').unbind('click').click(function() {
    if(confirm("Are you sure add these articles to latest open EDM event?")) {
        $.ajax({
            method: 'post',
            url: '{$this->resource}/addToEDM',
            data: {
                _token:'{$this->getToken()}',
                ids: selectedRows(),
                action: {$this->action}
            },
            success: function (result) {
                $.pjax.reload('#pjax-container');
                if(result.status) {
                    toastr.success(result.message);
                } else {
                    toastr.warning(result.message);
                }
            },
            error: function () {
                toastr.error('Server Error!');
            }
        });
    }
});

EOT;

    }
}