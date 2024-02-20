<?php

namespace S4mpp\AdminPanel\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use S4mpp\AdminPanel\Traits\WithAdminResource;

/**
 * @codeCoverageIgnore
 */
class TableRepeater extends Component
{
    // use WithAdminResource, WithPagination;

    // private $collection;
    
    // private array $columns = [];

	// public string $repater_name;

	// private $repeater;

	// public int $register_id;

    // public function mount(int $register_id, string $resource_name, string $repeater_name)
	// {
	// 	$this->register_id = $register_id;
		
	// 	$this->resource_name = $resource_name;
		
	// 	$this->repeater_name = $repeater_name;
    // }

    // public function booted()
    // {
    //     $this->_setResource($this->resource_name);

	// 	$this->repeater = $this->resource->getRepeaters()[$this->repeater_name] ?? null;

    //     $this->columns = $this->repeater?->getColumns() ?? [];
    // }
    
    // public function render()
    // {    
    //     return view('admin::livewire.table-repeater', [
    //         'collection' => $this->_getRegisters(),
    //         'columns' => $this->columns,
    //     ]);
    // }

    // private function _getRegisters()
    // {
	// 	$relation = $this->repeater->getRelation();
		
	// 	return $this->resource->getModel()->find($this->register_id)->{$relation}()
    //     ->orderBy($this->repeater->getFieldOrderBy(), $this->repeater->getDirectionOrderBy())
    //     ->paginate(10);
    // }
}
