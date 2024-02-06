<?php

namespace S4mpp\AdminPanel\Reports;

use S4mpp\AdminPanel\Utils;
use S4mpp\AdminPanel\Filter\Filter;
use S4mpp\AdminPanel\Traits\Slugable;
use S4mpp\AdminPanel\Traits\Titleable;
use S4mpp\AdminPanel\Reports\ReportResult;
use S4mpp\AdminPanel\Utils\Finder;

final class Report
{
	use Titleable, Slugable;

	// private $model;

	private array $possible_results = [];

	function __construct(private string $title, private array $fields)
	{
		$this->createSlug($title);

		return $this;
	}

	// public function setModel($model)
	// {
	// 	$this->model = $model;
	// }

	public function result(string $title, string $model = null, string $method = null, array $columns = [])
	{
		$report_result = new ReportResult($title, $model, $method);
		
		foreach($columns as $column)
		{
			$report_result->addColumn($column);
		}

		$this->possible_results[] = $report_result;
		
		return $this;
	}

	public function getFields(): array
	{
		return Finder::onlyOf($this->fields, Filter::class);
	}

	public function getPossibleResults(): array
	{
		return $this->possible_results;
	}

	// public function getRouteName(string $resource): string
	// {
	// 	return 'admin.'.$resource.'.report.'.$this->slug;
	// }
}