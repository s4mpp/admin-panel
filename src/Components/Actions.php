<?php

namespace S4mpp\AdminPanel\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Actions extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $local, public array $actions, public array $actionRoutes, public int $id, public ?string $element = 'text', public ?string $class = null)
	{}
    

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('admin::components.actions');
    }
}
