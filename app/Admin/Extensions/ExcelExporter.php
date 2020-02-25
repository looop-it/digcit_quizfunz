<?php
namespace App\Admin\Extensions;

use Encore\Admin\Grid;
use Encore\Admin\Grid\Exporters\AbstractExporter;
use Maatwebsite\Excel\Facades\Excel;

class ExcelExporter extends AbstractExporter
{
    protected $filename;
    protected $columns = [];

    public function __construct(Grid $grid = null, string $filename, array $columns)
    {
        parent::__construct($grid);

        $this->filename = $filename;
        $this->columns = $columns;
    }

    public function export()
    {
        Excel::create($this->filename, function ($excel) {
            $excel->sheet('Sheet 1', function ($sheet) {
                $rows = collect($this->getData())->map(function ($item) {
                    return array_only($item, $this->columns);
                });

                $sheet->rows($rows);
            });
        })->export('xls');
    }
}
