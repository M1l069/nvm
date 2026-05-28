<?php

namespace App\View\Components\Profile;

use App\Models\Teacher;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TeacherInfo extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public ?Teacher $teacher = null)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.profile.teacher-info');
    }
}
