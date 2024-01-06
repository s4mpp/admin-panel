<?php

namespace S4mpp\AdminPanel\Reports;

use S4mpp\AdminPanel\Column\Column as AdminColumn;
use S4mpp\AdminPanel\Factories\Column;
use S4mpp\AdminPanel\Traits\Titleable;

final class ReportResult
{
	use Titleable;

	private array $columns = [];

	function __construct(private string $title, public ?string $model = null, public ?string $method = null)
	{
		return $this;
	}

	public function getMethod(): ?string
	{
		return $this->method;
	}

	public function getModel(): ?string
	{
		return $this->model;
	}

	public function addColumn(AdminColumn $column)
	{
		$this->columns[] = $column;

		return $this;
	}

	public function getColumns(): array
	{
		if(!empty($this->columns))
		{
			return $this->columns;
		}

		return [
			Column::text('Título', 'title'),
			Column::text('Valor', 'value')
		];
	}
}