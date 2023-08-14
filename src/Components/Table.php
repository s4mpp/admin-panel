<?php

namespace S4mpp\AdminPanel\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;

class Table extends Component
{
    public $registers = [];

    /**
     * Create a new component instance.
     */
    public function __construct(public Collection | LengthAwarePaginator $collection, public array $columns, public array $actionRoutes, public array $actions = [])
    {

        foreach($collection as $row)
		{
			$data_row = [];
			
			foreach($columns as $column)
			{
				$data = clone $column;

				$data->original_data =  $row->{$column->field};
				$data->data = is_callable($column->callback) ? call_user_func($column->callback, $data->original_data) : $data->original_data;

				$data_row[] = $data;
			}

			$this->registers[$row->id] = $data_row;
		}
    }
    

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('admin::components.table');
    }
}
