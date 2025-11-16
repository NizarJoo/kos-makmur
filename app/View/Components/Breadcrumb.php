<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Breadcrumb extends Component
{
    public array $items;

    /**
     * Create a new component instance.
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('components.breadcrumb');
    }
}