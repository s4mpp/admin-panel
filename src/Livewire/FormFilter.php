<?php

namespace S4mpp\AdminPanel\Livewire;

use Livewire\Component;
use S4mpp\AdminPanel\Utils;
use S4mpp\AdminPanel\Filter\Search;
use S4mpp\AdminPanel\Traits\WithAdminResource;

class FormFilter extends Component
{
	use WithAdminResource;

	public $filters;

	public ?int $total_filters = null;
	
	protected $listeners = ['setField'];
	
	private $fields;
	
	private $search_fields = [];

	public function mount(string $resource_name)
	{
		$this->resource_name = $resource_name;
	}
	
	public function booted()
    {
		$this->_setResource($this->resource_name);

		/**
		 * @todo DUPLICATED
		 */
		$this->search_fields = $this->_getSearchFieldsForm();

		if(!isset($this->filters))
		{
			foreach($this->resource->getFilters() ?? [] as $input)
			{
				$this->filters[$input->getField()] = method_exists($input, 'getInitialValue') ? $input->getInitialValue() : null;
			}
		}
	}

	public function updatedFilters()
	{
		$total = 0;

		foreach($this->filters as $filter)
		{
			$is_empty = (is_array($filter) && empty(array_filter($filter)) || is_null($filter));
 			
			if(!$is_empty)
			{
				$total++;
			}
		}

		$this->total_filters = ($total > 0) ? $total : null;
	}

	/**
	 * @todo DUPLICATED
	 */
	public function setField(string $relation = null, string $field, $value = null)
	{
		$this->filters[$field] = $value;
		
		$this->dispatchBrowserEvent('close-modal');
		$this->dispatchBrowserEvent('reset-loading');
		
		$this->emitSelf('$refresh');
	}

	public function render()
	{
		return view('admin::livewire.form-filter', [
			// 'alpine_data_inputs' => $this->_getAlpineDataInputs(),
			'fields' => $this->resource->getFilters(),
			'search_fields' => $this->search_fields,
			'data_modals' => $this->_getDataModalsAttribute(),
			'close_modals' => $this->_getCloseModalsAttribute()
		]);
	}











	/**
	 *
	 * @todo DUPLICATED
	 */
	private function _getDataModalsAttribute(): array
	{
		foreach($this->search_fields ?? [] as $input)
		{
			$data_modals[] = 'modal'.$input->getField().': false';
		}

		return $data_modals ?? [];
	}

	/**
	 *
	 * @todo DUPLICATED
	 */
	private function _getCloseModalsAttribute(): array
	{
		foreach($this->search_fields ?? [] as $input)
		{
			$close_modals[] = 'modal'.$input->getField().' = false';
		}

		return $close_modals ?? [];
	}

	/**
	 *
	 * @todo DUPLICATED
	 */
	private function _getSearchFieldsForm(): array
	{
		$form_searchs = Utils::findElement($this->resource->getFilters(), Search::class);
	
		// foreach($form_searchs as $search)
		// {
		// 	$model = ($this->register) ? get_class($this->register->{$search->getRelationShip()}()->getRelated()) : null;
	
		// 	$search->setModel($model);
		// }

		return $form_searchs;
	}
}
