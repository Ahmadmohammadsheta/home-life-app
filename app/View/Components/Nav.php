<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Nav extends Component
{
    // if public it will be a parameter with the view
    // if it protected must add it to 
    public $items;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->items = config('nav');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nav');
    }
}
