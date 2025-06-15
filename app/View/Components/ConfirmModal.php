<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ConfirmModal extends Component
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

    public function render(): View|Closure|string
    {
        return view('components.confirm-modal');
    }
}
