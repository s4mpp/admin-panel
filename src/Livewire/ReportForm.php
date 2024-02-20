<?php

namespace S4mpp\AdminPanel\Livewire;

use Livewire\Component;
use S4mpp\AdminPanel\Traits\IsFilterForm;
use S4mpp\AdminPanel\Traits\WithAdminResource;
use S4mpp\AdminPanel\Traits\HasModalSearchInForm;

/**
 * @codeCoverageIgnore
 */
class ReportForm extends Component
{
	use WithAdminResource;
	//  IsFilterForm, HasModalSearchInForm;

	private $report;

	public string $report_slug;
	
	// public $filters;
	
	// public $report_name;
	
	// private $search_fields = [];
	
	// protected $listeners = ['setField'];

	public function mount($resource, $report)
	{
		$this->resource_slug = $resource->getSlug();
		
		$this->resource = $resource;

		$this->report_slug = $report->getSlug();
	}
	
	public function booted()
    {
		$this->loadResource();

		$this->report = $this->resource->getReport($this->report_slug);
	}

	public function render()
	{
		return view('admin::livewire.form-report', [
			'fields' => $this->report->getFields(),
			// 'search_fields' => $this->search_fields,
			// 'data_modals' => $this->_getDataModalsAttribute(),
			// 'close_modals' => $this->_getCloseModalsAttribute()
		]);
	}
}
