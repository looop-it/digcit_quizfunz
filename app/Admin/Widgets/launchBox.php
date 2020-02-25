<?php

namespace App\Admin\Widgets;

use Encore\Admin\Widgets\Widget;
use Illuminate\Contracts\Support\Renderable;

class launchBox extends Widget implements Renderable
{
    /**
     * @var string
     */
    protected $view = 'widgets.launchBox';

    /**
     * @var array
     */
    protected $data = [];

    /**
     * InfoBox constructor.
     *
     * @param string $name
     * @param string $action
     * @param string $link
     */
    public function __construct($name, $action, $color, $link)
    {
        $this->data = [
            'name'   => $name,
            'action' => $action,
            'link'   => $link,
        ];
        $this->class("small-box bg-$color");
    }

    /**
     * @return string
     */
    public function render()
    {
        $variables = array_merge($this->data, ['attributes' => $this->formatAttributes()]);

        return view($this->view, $variables)->render();
    }
}
