<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Table extends Component
{
    public $headers;
    public $rows;
    public $theme;

    public function __construct($headers, $rows, $theme)
    {
        $this->headers = $headers;
        $this->rows = $rows;
        $this->theme = $theme;
    }

    public function render()
    {
        return view('components.table');
    }
}
