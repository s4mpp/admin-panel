<?php

namespace S4mpp\AdminPanel\Livewire;

use Livewire\Component;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View as View;
use S4mpp\AdminPanel\Reports\Report;
use S4mpp\AdminPanel\Resources\Resource;
use Illuminate\Database\Eloquent\Collection;
use S4mpp\AdminPanel\Traits\WithAdminResource;

/**
 * @codeCoverageIgnore
 */
final class ReportResult extends Component
{
    use WithAdminResource;

    private Report $report;

    public string $report_slug;

    /**
     * @var array<string>
     */
    public ?array $filter_term = null;

    /**
     * @var array<string>
     */
    public array $filter_descriptions = [];

    // protected $listeners = ['filterReport'];

    public function mount(Resource $resource, Report $report): void
    {
        $this->resource_slug = $resource->getSlug();

        $this->resource = $resource;

        $this->report_slug = $report->getSlug();
    }

    // public function mount(string $report_slug, string $resource_name)
    // {
    // 	$this->report_slug = $report_slug;

    // 	$this->resource_name = $resource_name;
    // }

    public function booted(): void
    {
        $this->loadResource();

        $this->report = $this->resource->getReport($this->report_slug);
    }

    public function render(): View|ViewFactory
    {
        return view('admin::livewire.report', [
            // 'results' => $this->_getResults(),
        ]);
    }

    /**
     * @param array<string|int|null>
     */
    public function filter(array $params): void
    {
        $this->reset('filter_descriptions');

        $this->filter_term = $params['filters'] ?? null;

        foreach ($this->report->getFields() as $filter) {
            $term = $this->filter_term[$filter->getField()] ?? null;

            if (! $term) {
                continue;
            }

            $description_result = $filter->getDescriptionResult($term);

            if (! $description_result) {
                continue;
            }

            $this->filter_descriptions[] = $filter->getTitle().': '.$description_result;
        }

        $this->dispatchBrowserEvent('filter-complete');
    }

    // private function _getResults()
    // {
    // 	if(empty($this->filter_term))
    // 	{
    // 		return null;
    // 	}

    // 	$results = [];

    // 	$possible_results = $this->report->getPossibleResults();

    // 	foreach($possible_results as $result)
    // 	{
    // 		$model = $result->getModel() ?? $this->resource->getModel();

    // 		$registers = $model::{$result->getMethod()}(collect($this->filter_term));

    // 		$columns = $result->getColumns();

    // 		$values = $this->_response($registers, $columns);

    // 		$results[] = [
    // 			'title' => $result->getTitle(),
    // 			'columns' => $columns,
    // 			'values' => collect($values)
    // 		];
    // 	}

    // 	return $results;
    // }

    // private function _response(Collection $registers, array $columns)
    // {
    // 	$fields = [];

    // 	foreach($columns as $column)
    // 	{
    // 		$fields[] = $column->getField();
    // 	}

    // 	$registers->map(function($register) use ($fields)
    // 	{
    // 		return $register->only($fields);
    // 	});

    // 	$sort_by = end($fields);

    // 	if($sort_by)
    // 	{
    // 		$registers = $registers->sortByDesc(end($fields));
    // 	}

    // 	return $registers;

    // }
}
