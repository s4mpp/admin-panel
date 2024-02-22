<?php

namespace S4mpp\AdminPanel\Reports;

use S4mpp\AdminPanel\Labels\Label;
use S4mpp\AdminPanel\Utils\Finder;
use S4mpp\AdminPanel\Filter\Filter;
use S4mpp\AdminPanel\Traits\Slugable;
use S4mpp\AdminPanel\Traits\Titleable;

final class Report
{
    use Slugable, Titleable;

    // private $model;

    /**
     * @var array<ReportResult>
     */
    private array $possible_results = [];

    /**
     * @param array<Filter> $fields
     */
    public function __construct(private string $title, private array $fields)
    {
        $this->createSlug($title);
    }

    // public function setModel($model)
    // {
    // 	$this->model = $model;
    // }

    /**
     * @param  array<Label>  $columns
     */
    public function result(string $title, ?string $model = null, ?string $method = null, array $columns = []): self
    {
        $report_result = new ReportResult($title, $model, $method);

        foreach ($columns as $column) {
            $report_result->addColumn($column);
        }

        $this->possible_results[] = $report_result;

        return $this;
    }

    /**
     * @return array<Filter>
     */
    public function getFields(): array
    {
        return Finder::onlyOf($this->fields, Filter::class);
    }

    /**
     * @return array<ReportResult>
     */
    public function getPossibleResults(): array
    {
        return $this->possible_results;
    }

    // public function getRouteName(string $resource): string
    // {
    // 	return 'admin.'.$resource.'.report.'.$this->slug;
    // }
}
