<?php

namespace App\View\Components\Profile;

use App\Models\Guardian;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ParentInfo extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public ?Guardian $parent = null)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.profile.parent-info');
    }
}
