<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */
 
 
use Encore\Admin\Grid\Exporter;
use App\Admin\Extensions\CsvExporter;

Exporter::extend('CsvExporter', CsvExporter::class);


Encore\Admin\Form::forget(['map']);

use Encore\Admin\Grid\Column;

Column::extend('deleteLine', function ($value) {
    return "<s style='color: gray'>$value</s>";
});

//define lang package
// app('translator')->addNamespace('admin', resource_path('lang/admin'));

use Encore\Admin\Facades\Admin;

Admin::js('/bower/chart.js/dist/Chart.min.js');

//define summernote Editor
use App\Admin\Extensions\summernoteEditor;
use Encore\Admin\Form;

Form::extend('editor', summernoteEditor::class);

app('view')->prependNamespace('admin', resource_path('views/admin'));
