<?php

namespace S4mpp\AdminPanel\Traits;

use Illuminate\Database\Eloquent\Builder;
use S4mpp\AdminPanel\Filter\Filter;

trait Filterable
{
    /**
     * @var array<string>
     */
    public array $filters = [];

    /**
     * @param array<string> $params
     */
    public function filter(array $params): void
    {
        $this->filters = $params['filters'] ?? [];

        $this->resetPage();

        $this->dispatchBrowserEvent('filter-complete');
    }

    private function executeQuery(Filter $filter, Builder $query): void
    {
        $term = $this->filters[$filter->getField()] ?? null;

        if (is_null($term) || empty($term)) {
            return;
        }

        $filter->query($query, $term);
    }

    /**
     * @param array<Filter> $filters_fields
     */
    private function isAllFiltersEmpty(array $filters_fields): bool
    {
        foreach ($filters_fields as $filter_field) {
            $term = $this->filters[$filter_field->getField()] ?? null;

            $is_empty = (is_null($term) || empty($term));

            if (! $is_empty) {
                return false;
            }
        }

        return true;
    }
}
