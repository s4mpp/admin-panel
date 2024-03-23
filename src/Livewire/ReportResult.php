<?php

namespace S4mpp\AdminPanel\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Contracts\View\View;
use S4mpp\AdminPanel\Elements\Report;
use S4mpp\AdminPanel\Traits\Filterable;
use S4mpp\AdminPanel\Resources\Resource;
use Illuminate\Database\Eloquent\Collection;
use S4mpp\AdminPanel\Traits\WithAdminResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory as ViewFactory;

/**
 * @codeCoverageIgnore
 */
final class ReportResult extends Component
{
    use Filterable, WithAdminResource, WithPagination;

    private Report $report;

    public string $report_slug;

    public int|string|null $filter_term = null;

    /**
     * @var array<string>
     */
    protected $listeners = ['filter'];

    // /**
    //  * @var array<string>
    //  */
    // public array $filter_descriptions = [];

    // protected $listeners = ['filterReport'];

    public function mount(string $resource_slug, string $report_slug): void
    {
        $this->resource_slug = $resource_slug;

        $this->report_slug = $report_slug;
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
        return view('admin::livewire.table-report', [
            'report' => $this->report,
            'registers' => $this->_getRegisters(),
        ]);
    }

    // /**
    //  * @param  array<string|int|null>  $params
    //  */
    // public function filter(array $params): void
    // {
    //     $this->reset('filter_descriptions');

    //     $this->filter_term = $params['filters'] ?? null;

    //     foreach ($this->report->getFields() as $field) {
    //         $term = $this->filter_term[$field->getField()] ?? null;

    //         if (! $term) {
    //             continue;
    //         }

    //         $description_result = $field->getDescriptionResult($term);

    //         if (! $description_result) {
    //             continue;
    //         }

    //         $this->filter_descriptions[] = $field->getTitle().': '.$description_result;
    //     }

    //     $this->dispatch('filter-complete');
    // }

    private function _getRegisters(): ?LengthAwarePaginator
    {
        if (empty($this->filters)) {
            return null;
        }

        // $results = [];

        // $results = $this->report->getPossibleResults();

        // foreach($results as $result)
        // {
        // $model = $result->getModel();

        // $method = $result->getMethod();

        $registers = call_user_func($this->report->getCallbackFilter(), $this->resource->getModel(), function ($query): void {
            foreach ($this->resource->filters() as $field) {
                $this->executeQuery($field, $query);
            }
        });

        return $registers;

        // $this->report_result->setData($data);

        // }

        // return $results;

        // foreach($possible_results as $result)
        // {
        // 	$model = $result->getModel() ?? $this->resource->getModel();

        // 	$registers = $model::{$result->getMethod()}(collect($this->filter_term));

        // 	$columns = $result->getColumns();

        // 	$values = $this->_response($registers, $columns);

        // 	$results[] = [
        // 		'title' => $result->getTitle(),
        // 		'columns' => $columns,
        // 		'values' => collect($values)
        // 	];
        // }

        // return $results;
    }

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
