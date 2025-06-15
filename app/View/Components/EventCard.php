<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Event;

class EventCard extends Component
{
    public $event;
    public $theme;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(Event $event, $theme)
    {
        $this->event = $event;
        $this->theme = $theme;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.event-card');
    }
}
