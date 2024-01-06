<?php

namespace S4mpp\AdminPanel\Livewire;

use Livewire\Component;
use S4mpp\AdminPanel\Factories\Column;
use S4mpp\AdminPanel\Traits\WithAdminResource;

class Report extends Component
{
	use WithAdminResource;

	public $report_name;

	public ?array $filter_term = null;
	
	private $report;

	protected $listeners = ['filterReport'];
	
	public function mount(string $report_name, string $resource_name)
	{
		$this->report_name = $report_name;

		$this->resource_name = $resource_name;
	}

	public function booted()
    {
		$this->_setResource($this->resource_name);

		$this->_loadReport();
	}

	public function render()
	{
		return view('admin::livewire.report', [
			'results' => $this->_getResults(),
		]);
	}

	public function filterReport(array $params)
	{
        $this->filter_term = $params['filters'] ?? null;

		$this->dispatchBrowserEvent('filter-complete');
	}

	private function _loadReport()
	{
		$this->report = $this->resource->getReport($this->report_name);
	}

	private function _getResults()
	{
		if(empty($this->filter_term))
		{
			return null;
		}

		$results = [];

		$possible_results = $this->report->getPossibleResults();

		foreach($possible_results as $result)
		{
			$model = $result->getModel() ?? $this->resource->getModel();

			$values = $model::{$result->getMethod()}($this->filter_term);

			$results[] = [
				'title' => $result->getTitle(),
				'columns' => $result->getColumns(),
				'values' => collect($values)
			];
		}

		return $results;
	}
}
