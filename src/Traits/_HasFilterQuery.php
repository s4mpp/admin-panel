<?php

namespace S4mpp\AdminPanel\Traits;

use S4mpp\AdminPanel\Filter\Period;
use S4mpp\AdminPanel\Filter\Search;
use S4mpp\AdminPanel\Filter\Multiple;

trait HasFilterQuery
{
    // public function scopeFilterSearchRelation($query, string $relation, string $field, int $id = null)
    // {
    //     $query->whereRelation($relation, function($query) use ($field, $id)
    //     {
    //         Search::query($query, $field, $id);
    //     });
    // }

    // public function scopeFilterSearch($query, string $field, int $id = null)
    // {
    //     $query->where(function($query) use ($field, $id)
    //     {
    //         Search::query($query, $field, $id);
    //     });
    // }

    // public function scopeFilterMultipleRelation($query, string $relation, string $field, $id = null)
    // {
    //     $query->whereRelation($relation, function($query) use ($field, $id)
    //     {
    //         Multiple::query($query, $field, $id);
    //     });
    // }

    // public function scopeFilterMultiple($query, string $field, $id = null)
    // {
    //     $query->where(function($query) use ($field, $id)
    //     {
    //         Multiple::query($query, $field, $id);
    //     });
    // }

    // public function scopeFilterPeriodRelation($query, string $relation, string $field, string $start = null, string $end = null)
    // {
    //     $query->whereRelation($relation, function($query) use ($field, $start, $end)
    //     {
    //         Period::query($query, $field, $start, $end);
    //     });
    // }

    // public function scopeFilterPeriod($query,  string $field, string $start = null, string $end = null)
    // {
    //     $query->where(function($query) use ($field, $start, $end)
    //     {
    //         Period::query($query, $field, $start, $end);
    //     });
    // }
}
