<?php

namespace S4mpp\AdminPanel\Reports;

use S4mpp\AdminPanel\Labels\Label;
use S4mpp\AdminPanel\Traits\Titleable;

final class ReportResult
{
    use Titleable;

    /**
     * @var array<Label>
     */
    private array $columns = [];

    public function __construct(private string $title, public ?string $model = null, public ?string $method = null)
    {
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    /**
     * @return array<Label>
     */
    public function addColumn(Label $label): self
    {
        $this->columns[] = $label;

        return $this;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }
}
