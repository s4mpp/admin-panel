<?php

namespace S4mpp\AdminPanel\Filter;

use S4mpp\AdminPanel\Traits\Titleable;
use Illuminate\Database\Eloquent\Builder;

abstract class Filter
{
    use Titleable;

    public function __construct(private string $title, private string $field)
    {
    }

    public function getAlpineExpression(): string
    {
        return '{}';
    }

    public function getField(): string
    {
        return $this->field;
    }

    /**
     * @param  array<string>  $term
     */
    public function query(Builder $builder, array|int|string $term): void
    {
        $builder->where($this->field, $term);
    }
}
