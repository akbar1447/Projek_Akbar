<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class nav-button extends Component
{
    /**
     * Create a new component instance.
     *@return void
     */
    public $class;
    public $id;
    public $label;
    public $icon;

    public function __construct($class,$id,$label,$icon)
    {
        $this->class=$class;
        $this->id=$id;
        $this->label=$label;
        $this->icon=$icon;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nav-button');
    }
}
