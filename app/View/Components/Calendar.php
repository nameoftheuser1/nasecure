<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Calendar extends Component
{
    public $dates;

    public function __construct($dates)
    {
        $this->dates = $dates;
    }

    public function render(): View|Closure|string
    {
        return view('components.calendar');
    }
}
