<?php

namespace App\Admin\Widgets\Chart;

use Illuminate\Support\Arr;
use Encore\Admin\Widgets\Chart\Chart as Chart;

class Line extends Chart
{
    protected $labels = [];

    protected $options = [
        'responsive'          => true,
        'maintainAspectRatio' => false,
        'title'               => 'xxxx',
    ];

    public function __construct($labels = [], $data = [])
    {
        $this->data['labels'] = $labels;

        $this->data['datasets'] = [];

        $this->add($data);
    }

    public function add($label, $data = [], $fillColor = '')
    {
        if (is_array($label)) {
            if (Arr::isAssoc($label)) {
                $this->data[] = $label;
            } else {
                foreach ($label as $item) {
                    call_user_func_array([$this, 'add'], $item);
                }
            }

            return $this;
        }

        $this->data['datasets'][] = [
            'fill'  => false,
            'borderColor'     => $fillColor,
            'fillColor'     => '#ffffff',
            'strokeColor' => "rgba(220,220,220,1)",
            'pointColor' => "rgba(220,220,220,1)",
            'pointStrokeColor' => "#fff",
            'backgroundColor' => '#f2f2f2',
            'label'         => $label,
            'data'          => $data,
        ];

        return $this;
    }

    protected $defaultColors = [
        '#dd4b39', '#00a65a', '#f39c12',
        '#00c0ef', '#3c8dbc', '#0073b7',
        '#39cccc', '#ff851b', '#01ff70',
        '#605ca8', '#f012be', '#777',
        '#001f3f', '#d2d6de',
    ];

    protected function fillColor($data)
    {
        foreach ($data['datasets'] as &$item) {
            if (empty($item['borderColor'])) {
                $item['borderColor'] = array_shift($this->defaultColors);
            }
        }

        return $data;
    }

    public function script()
    {
        $data = $this->fillColor($this->data);

        $data = json_encode($data);

        $options = json_encode([$this->options]);

        return <<<EOT

(function() {
    var canvas = $("#{$this->elementId}").get(0).getContext("2d");
var chart = new Chart(canvas, {
    type: 'line',
    data: $data,
    options: $options,
});

})();
EOT;
    }
}
