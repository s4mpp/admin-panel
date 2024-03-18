<?php

namespace S4mpp\AdminPanel\Traits;

use S4mpp\AdminPanel\Filter\Filter;

trait Filterable
{
    public ?array $filters = [];

    public function filter(array $params): void
    {
        $this->filters = $params['filters'] ?? null;

        $this->resetPage();

        $this->dispatchBrowserEvent('filter-complete');
    }

    private function executeQuery(Filter $filter, $query): void
    {
        $term = $this->filters[$filter->getField()] ?? null;

        if (is_null($term) || empty($term)) {
            return;
        }

        $filter->query($query, $term);
    }

    private function isAllFiltersEmpty(array $filters_fields)
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
