<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public $title;
    public $id;
    public $theme;

    public function __construct($title, $id, $theme)
    {
        $this->title = $title;
        $this->id = $id;
        $this->theme = $theme;
    }

    public function render()
    {
        return view('components.modal');
    }
}
