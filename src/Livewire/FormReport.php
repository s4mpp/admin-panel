<?php

namespace S4mpp\AdminPanel\Livewire;

use Livewire\Component;
use S4mpp\AdminPanel\Utils;
use S4mpp\AdminPanel\Filter\Search;
use S4mpp\AdminPanel\Traits\WithAdminResource;

class FormReport extends Component
{
	use WithAdminResource;

	public $report_name;

	public $filters;
	
	protected $listeners = ['setField'];
	
	private $report;
	
	private $search_fields = [];

	public function mount(string $report_name, string $resource_name)
	{
		$this->report_name = $report_name;

		$this->resource_name = $resource_name;
	}
	
	public function booted()
    {
		$this->_setResource($this->resource_name);

		$this->_loadReport();

		/**
		 * @todo DUPLICATED
		 */
		$this->search_fields = $this->_getSearchFieldsForm();

		if(!isset($this->filters))
		{
			foreach($this->search_fields ?? [] as $input)
			{
				$this->filters[$input->getField()] = null;
			}
		}
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
		return view('admin::livewire.form-report', [
			// 'alpine_data_inputs' => $this->_getAlpineDataInputs(),
			'fields' => $this->report->getFields(),
			'search_fields' => $this->search_fields,
			'data_modals' => $this->_getDataModalsAttribute(),
			'close_modals' => $this->_getCloseModalsAttribute()
		]);
	}

	private function _loadReport()
	{
		$this->report = $this->resource->getReport($this->report_name);
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
		$form_searchs = Utils::findElement($this->report->getFields(), Search::class);
	
		// foreach($form_searchs as $search)
		// {
		// 	$model = ($this->register) ? get_class($this->register->{$search->getRelationShip()}()->getRelated()) : null;
	
		// 	$search->setModel($model);
		// }

		return $form_searchs;
	}
}
