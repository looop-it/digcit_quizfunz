<?php

namespace App\Admin\Extensions;

use Encore\Admin\Form\Field;

class CKEditor extends Field
{
    public static $js = [
        '/vendor/laravel-admin/ckeditor5-classic/ckeditor.js?ver=1.0',
    ];

    protected $view = 'ckeditor.editor';

    public function render()
    {
        // $lang = strtolower(app()->getLocale());
        // $lang = 'zh';

        $upload_url = route('editor.upload_image');
        $csrf_token = csrf_token();

        $script = <<<SCRIPT
           
            ClassicEditor.create( document.querySelector('#{$this->id}'), {
				toolbar: {
					items: [
						'heading',
						'|',
						'bold',
						'italic',
                        'fontColor',
                        //'fontSize',
						'fontBackgroundColor',
						'removeFormat',
						'|',
						'alignment',
						'bulletedList',
						'numberedList',
						'|',
						'link',
						'imageUpload',
						'mediaEmbed',
						'blockQuote',
						'insertTable',
						'undo',
						'redo'
					]
				},
                mediaEmbed: {
                    previewsInData: true,
                    removeProviders: [ 'instagram', 'twitter', 'googleMaps', 'flickr', 'facebook' ]
                },
				language: 'zh',
				image: {
                    styles: [
                        'alignLeft', 'alignCenter', 'alignRight'
                    ],
					toolbar: [
                        'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight',
                        '|',    
                        'imageTextAlternative',
                        'imageStyle:full',
                        'imageStyle:side',
					]
				},
				simpleUpload: {
                    uploadUrl: '{$upload_url}',
                    headers: {
                        'X-CSRF-TOKEN': '{$csrf_token}'
                    }
                },
				table: {
					contentToolbar: [
						'tableColumn',
						'tableRow',
						'mergeTableCells'
					]
				},
				licenseKey: '',
				
			} )
			.then( editor => {
				window.editor = editor;
			})
			.catch( error => {
				console.error( 'Oops, something gone wrong!' );
				console.error( 'Please, report the following error in the https://github.com/ckeditor/ckeditor5 with the build id and the error stack trace:' );
				console.warn( 'Build id: illn8lgkup2i-4r3ldttfqo7h' );
				console.error( error );
			} );
SCRIPT;
        $this->script = $script;

        return parent::render();
    }
}
