<?php
namespace App\Admin\Extensions;

use Encore\Admin\Form\Field;
use Illuminate\Support\Facades\Storage;

class SummernoteEditor extends Field
{
    protected $view = 'summernote.editor';

    protected static $css = [
        '/bower/summernote/dist/summernote.css',
    ];
    protected static $js = [
        '/bower/summernote/dist/summernote.min.js',
    ];
    public function render()
    {
        $this->script = <<<EOT
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('input[name="_token"]').attr('value')
    }
});
$(document).ready(function() {
    $('#{$this->id}').summernote({
        height: 500,
        fontNames: ['Microsoft JhengHei', 'Microsoft YaHei', 'Heiti TC', 'PMingLiU', 'KaiTi', 'Arial', 'Arial Black', 'Comic Sans MS', 'Helvetica', 'Times New Romanm', 'Verdana' ],
        fontNamesIgnoreCheck: ['Microsoft JhengHei', 'Microsoft YaHei', 'Heiti TC', 'PMingLiU', 'KaiTi'],
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['fontname', 'fontsize', 'color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['picture', 'video', 'link', 'table']],
            ['misc', ['undo', 'redo', 'fullscreen', 'codeview', 'help']]
            ],
        
        dialogsFade: true,
        placeholder: 'write content here...',
        callbacks: {
            onImageUpload: function(files) {
                for (var i = 0; i<files.length; i++) {
                    sendFile(files[i])
                    // console.log(files[i]); 
                }
            }
        }
    });
    function sendFile(file) {
        var  data = new FormData();
        data.append("file", file);
        var url = '/admin/posts/upload';
        $.ajax({
            data: data,
            type: "POST",
            url: url,
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                if(data.success) {
                    toastr.success(data.url+' uploaded');
                    console.log(data.url+' uploaded');
                    $('#{$this->id}').summernote('insertImage',data.url );
                }else {
                    // alert(data.errors);
                    toastr.error(data.errors);
                    console.log(data.errors);
                }
                
            },
            error: function () {
                toastr.error('Server Error!');
            }
        });
    }
});
EOT;
        return parent::render();
    }

    public function imageUpload()
    {
        $image = Input::file('image');
        $dir = public_path();
    }
}
