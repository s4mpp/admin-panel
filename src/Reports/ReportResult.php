<?php

namespace S4mpp\AdminPanel\Reports;

use S4mpp\AdminPanel\Column\Column as AdminColumn;
use S4mpp\AdminPanel\Factories\Column;
use S4mpp\AdminPanel\Labels\Label;
use S4mpp\AdminPanel\Traits\Titleable;

final class ReportResult
{
	use Titleable;

	private array $columns = [];

	function __construct(private string $title, public ?string $model = null, public ?string $method = null)
	{}

	public function getMethod(): ?string
	{
		return $this->method;
	}

	public function getModel(): ?string
	{
		return $this->model;
	}

	public function addColumn(Label $label)
	{
		$this->columns[] = $label;

		return $this;
	}

	public function getColumns(): array
	{
		return $this->columns;
	}
}