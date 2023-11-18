<?php

namespace S4mpp\AdminPanel\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Table extends Component
{
    public int $rowspan_empty;

    /**
     * Create a new component instance.
     */
    public function __construct(public array $columns, public $registers = [])
    {
        $this->registers = $this->_mountColumnsData($registers);

        $this->rowspan_empty = count($columns) ?? 1;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('admin::components.table');
    }

    private function _mountColumnsData($collection = null)
    {
        if(!$collection)
        {
            return [];
        }

        foreach($collection as $row)
        {
            $data_row = [];
			
			foreach($this->columns as $column)
			{            		
                $data_row[] = $this->_getDataRow(clone $column, $row);
			}
            			
            $registers[] = ['registers' => $data_row];
        }

        return $registers ?? [];
    }

    private function _getDataRow($column, $row)
    {
        $path = explode('.', $column->getField());

        $column->original_data = $row[$path[0]] ?? null;

        if($column->original_data)
        {
            array_shift($path);

            foreach($path as $relation)
            {
                $column->original_data = $column->original_data[$relation];
            }
        }
        
        $column->data = is_callable($column->getCallback()) ? call_user_func($column->getCallback(), $column->original_data) : $column->original_data;
        
        return $column;
    }
}
