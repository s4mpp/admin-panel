<?php

namespace S4mpp\AdminPanel\Livewire;

use Livewire\Component;
use S4mpp\AdminPanel\Traits\IsFilterForm;
use S4mpp\AdminPanel\Traits\WithAdminResource;
use S4mpp\AdminPanel\Traits\HasModalSearchInForm;

/**
 * @codeCoverageIgnore
 */
final class FormFilter extends Component
{
    // use WithAdminResource, IsFilterForm, HasModalSearchInForm;

    // public $filters;

    // private $fields;

    // public ?int $total_filters = null;

    // protected $listeners = ['setField'];

    // public function mount(string $resource_name)
    // {
    // 	$this->resource_name = $resource_name;
    // }

    // public function booted()
    // {
    // 	$this->_setResource($this->resource_name);
    // }

    // public function updatedFilters()
    // {
    // 	$total = 0;

    // 	foreach($this->filters as $filter)
    // 	{
    // 		$is_empty = (is_array($filter) && empty(array_filter($filter)) || is_null($filter));

    // 		if(!$is_empty)
    // 		{
    // 			$total++;
    // 		}
    // 	}

    // 	$this->total_filters = ($total > 0) ? $total : null;
    // }

    // public function render()
    // {
    // 	return view('admin::livewire.form-filter', [
    // 		'fields' => $this->resource->getFilters(),
    // 		'search_fields' => $this->search_fields,
    // 		'data_modals' => $this->_getDataModalsAttribute(),
    // 		'close_modals' => $this->_getCloseModalsAttribute()
    // 	]);
    // }
}
