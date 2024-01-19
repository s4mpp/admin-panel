<?php

namespace S4mpp\AdminPanel\Livewire;

use Livewire\Component;
use S4mpp\AdminPanel\Traits\IsFilterForm;
use S4mpp\AdminPanel\Traits\WithAdminResource;
use S4mpp\AdminPanel\Traits\HasModalSearchInForm;

class FormReport extends Component
{
	use WithAdminResource, IsFilterForm, HasModalSearchInForm;

	private $report;
	
	public $filters;
	
	public $report_name;
	
	private $search_fields = [];
	
	protected $listeners = ['setField'];

	public function mount(string $report_name, string $resource_name)
	{
		$this->report_name = $report_name;

		$this->resource_name = $resource_name;
	}
	
	public function booted()
    {
		$this->_setResource($this->resource_name);

		$this->report = $this->resource->getReport($this->report_name);
	}

	public function render()
	{
		return view('admin::livewire.form-report', [
			'fields' => $this->report->getFields(),
			'search_fields' => $this->search_fields,
			'data_modals' => $this->_getDataModalsAttribute(),
			'close_modals' => $this->_getCloseModalsAttribute()
		]);
	}
}
