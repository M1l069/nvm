<?php

namespace App\View\Components\Welcome\WelcomeComponents;

use App\Models\Band;
use App\Models\Event;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EventInfo extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public ?Event $event = null,
                                public ?Band $band = null)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.welcome.welcome-components.event-info');
    }
}
