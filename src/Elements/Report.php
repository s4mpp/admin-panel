<?php

namespace S4mpp\AdminPanel\Elements;

use Closure;
use S4mpp\AdminPanel\Labels\Label;
use S4mpp\AdminPanel\Utils\Finder;
use S4mpp\AdminPanel\Filter\Filter;
use S4mpp\AdminPanel\Traits\Slugable;
use S4mpp\AdminPanel\Traits\Titleable;

final class Report
{
    use Slugable, Titleable;

    // private $model;

    // /**
    //  * @var array<ReportResult>
    //  */
    // private array $possible_results = [];

    /**
     * @param  array<Label>  $columns
     */
    public function __construct(private string $title, private Closure $callback_filter, private array $columns)
    {
        $this->createSlug($title);
    }

    /**
     * @return array<Label>
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getCallbackFilter(): Closure
    {
        return $this->callback_filter;
    }

    // public function setModel($model)
    // {
    // 	$this->model = $model;
    // }

    // /**
    //  * @param  array<Label>  $columns
    //  */
    // public function result(string $title, Closure $result, array $columns): self
    // {
    //     $report_result = new ReportResult($title, $result);

    //     foreach (Finder::onlyOf($columns, Label::class) as $column) {
    //         $report_result->addColumn($column);
    //     }

    //     $this->possible_results[] = $report_result;

    //     return $this;
    // }

    // /**
    //  * @return array<mixed>
    //  */
    // public function getFields(): array
    // {
    //     return Finder::onlyOf($this->fields, Filter::class);
    // }

    // /**
    //  * @return array<ReportResult>
    //  */
    // public function getPossibleResults(): array
    // {
    //     return $this->possible_results;
    // }

    // public function getRouteName(string $resource): string
    // {
    // 	return 'admin.'.$resource.'.report.'.$this->slug;
    // }
}
