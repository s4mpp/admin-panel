<?php

namespace S4mpp\AdminPanel\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use S4mpp\AdminPanel\Factories\Column;
use S4mpp\AdminPanel\Traits\WithAdminResource;

class Report extends Component
{
	use WithAdminResource;

	public $report_name;

	public ?array $filter_term = null;
	
	private $report;

	public $filter_descriptions = [];

	protected $listeners = ['filterReport'];
	
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
		return view('admin::livewire.report', [
			'results' => $this->_getResults(),
		]);
	}

	public function filterReport(array $params)
	{
		$this->reset('filter_descriptions');

        $this->filter_term = $params['filters'] ?? null;

		foreach($this->report->getFields() as $filter)
		{
			$term = $this->filter_term[$filter->getField()] ?? null;
			
			/**
			 * DUPLICATED
			 */
			if(!$term || empty($term))
			{
				continue;
			}

			$description_result = $filter->getDescriptionResult($term);
	
			if(!$description_result)
			{
				continue;
			}
	
			$this->filter_descriptions[] = $filter->getTitle().': '.$description_result;
		}

		$this->dispatchBrowserEvent('filter-complete');

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

			$registers = $model::{$result->getMethod()}(collect($this->filter_term));

			$columns = $result->getColumns();

			$values = $this->_response($registers, $columns);

			$results[] = [
				'title' => $result->getTitle(),
				'columns' => $columns,
				'values' => collect($values)
			];
		}

		return $results;
	}

	private function _response(Collection $registers, array $columns)
	{
		$fields = [];

		foreach($columns as $column)
		{
			$fields[] = $column->getField();
		}

		$registers->map(function($register) use ($fields)
		{
			return $register->only($fields);
		});

		$sort_by = end($fields);

		if($sort_by)
		{
			$registers = $registers->sortByDesc(end($fields));
		}

		return $registers;
		
	}
}
