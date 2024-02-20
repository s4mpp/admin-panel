<?php

namespace S4mpp\AdminPanel\Components;

use Closure;
use Illuminate\View\Component;
use S4mpp\AdminPanel\Table\Cell;
use Illuminate\Support\Collection;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;

class Table extends Component
{
    // public int $rowspan_empty = 0;

    // public array $rows = [];


    /**
     * Create a new component instance.
     */
    public function __construct(
        // public array $labels = [], 
        public Collection | LengthAwarePaginator | array $collection = []
    )
    {
        // $this->rows = $this->getRows($labels, $collection);


        // $this->registers = $this->_mountColumnsData($collection);

        // $this->rowspan_empty = count($columns) ?? 1;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('admin::components.table');
    }

    // private function getRows(array $labels, Collection | LengthAwarePaginator | array $collection)
    // {
    //     foreach($collection as $register)
    //     {
    //         $cells = [];

    //         foreach($labels as $label)
    //         {
    //             $field = $label->getField();

    //             $cells[] = new Cell($label, $register->{$field});
    //         }

    //         $rows[] = $cells; 
    //     }

    //     return $rows ?? [];
    // }

    







    
    // private function _mountColumnsData($collection = null)
    // {
    //     if(!$collection)
    //     {
    //         return [];
    //     }

    //     foreach($collection as $row)
    //     {
    //         $data_row = [];
			
	// 		foreach($this->columns as $column)
	// 		{            		
    //             $data_row[] = $this->_getDataRow(clone $column, $row);
	// 		}
            			
    //         $registers[] = ['registers' => $data_row, 'original' => $row];
    //     }

    //     return $registers ?? [];
    // }

    // private function _getDataRow($column, $row)
    // {
    //     $path = explode('.', $column->getField());

    //     $column->original_data = $row[$path[0]] ?? null;

    //     if($column->original_data)
    //     {
    //         array_shift($path);

    //         foreach($path as $relation)
    //         {
    //             $column->original_data = $column->original_data[$relation];
    //         }
    //     }

    //     $column->data = $column->hasCallbacks() ? $column->runCallbacks($column->original_data) : $column->original_data;

    //     return $column;
    // }
}
