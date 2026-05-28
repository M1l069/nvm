<?php

namespace App\View\Components\Dashboard;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Teacher extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public ?User $user = null)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.teacher');
    }
}
