<?php

namespace S4mpp\AdminPanel\Filter;

use Illuminate\Database\Eloquent\Builder;
use S4mpp\AdminPanel\Traits\HasComponent;

final class Period extends Filter
{
    use HasComponent;

    /**
     * @var string|array<string>
     */
    protected string|array $component = 'admin::filter.period';

    public function getAlpineExpression(): string
    {
        return '{start: null, end: null}';
    }

    // public function render(): View|ViewFactory
    // {
    //     return view('admin::filter.period', ['filter' => $this]);
    // }

    // public function getInitialValue(): array
    // {
    // 	return ['start' => null, 'end' => null];
    // }

    // /**
    //  * @deprecated
    //  */
    // public function filter($term, $query)
    // {
    // 	self::query($query, $this->getField(), $term['start'], $term['end']);
    // }

    /**
     * @param  array<string>  $term
     */
    public function query(Builder $builder, array $term): void
    {
        extract($term);

        if (isset($start) && $start) {
            $builder->where($this->getField(), '>=', $start.' 00:00:00');
        }

        if (isset($end) && $end) {
            $builder->where($this->getField(), '<=', $end.' 23:59:59');
        }
    }

    /**
     * @param  array<string>  $term
     */
    public function getDescriptionResult(array $term): ?string
    {
        $start = $term['start'] ?? null;
        $end = $term['end'] ?? null;

        if ($start && ! $end) {
            $description = 'a partir de '.date('d/m/Y', strtotime($start));
        } elseif (! $start && $end) {
            $description = 'até '.date('d/m/Y', strtotime($end));
        } elseif ($start && $end) {
            $description = date('d/m/Y', strtotime($start)).' a '.date('d/m/Y', strtotime($end));
        }

        return $description ?? null;
    }
}
