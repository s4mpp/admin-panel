<?php

namespace S4mpp\AdminPanel\Filter;

use S4mpp\AdminPanel\Traits\HasComponent;

final class Period extends Filter
{
    use HasComponent;

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

    public function query($builder, array $term): void
    {
        extract($term);

        if (isset($start) && $start) {
            $builder->where($this->getField(), '>=', $start.' 00:00:00');
        }

        if (isset($end) && $end) {
            $builder->where($this->getField(), '<=', $end.' 23:59:59');
        }
    }

    // public function getDescriptionResult($term)
    // {
    // 	$start = $term['start'] ?? null;
    // 	$end = $term['end'] ?? null;

    // 	if($start && !$end)
    // 	{
    // 		$description = 'a partir de '.date('d/m/Y', strtotime($start));
    // 	}
    // 	else if(!$start && $end)
    // 	{
    // 		$description = 'até '.date('d/m/Y', strtotime($end));
    // 	}
    // 	else if($start && $end)
    // 	{
    // 		$description = date('d/m/Y', strtotime($start)).' a '.date('d/m/Y', strtotime($end));
    // 	}

    // 	return $description ?? null;
    // }
}
