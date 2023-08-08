<?php

namespace S4mpp\AdminPanel\Components;

use Closure;
use Illuminate\View\Component;
use S4mpp\AdminPanel\Table\Table as TableBuilder;
use Illuminate\Contracts\View\View;

class Table extends Component
{
    public $provider;

    public $columns;

    public $actions;
    
    public $data_table;

    /**
     * Create a new component instance.
     */
    public function __construct(TableBuilder $provider, public $actionRoutes = [1])
    {
        $this->provider = $provider->original_collection;

        $this->columns = $provider->columns;

        $this->data_table = $provider->data;
        
        $this->actions = $provider->actions;
    }
    

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('admin::components.table');
    }
}
