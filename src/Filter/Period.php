<?php

namespace S4mpp\AdminPanel\Filter;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View as View;

final class Period extends Filter
{
    public function render(): View|ViewFactory
    {
        return view('admin::filter.period', ['filter' => $this]);
    }

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

    // public static function query($query, string $field, string $start = null, string $end = null)
    // {
    // 	if(isset($start) && $start)
    // 	{
    // 		$query->where($field, '>=', $start.' 00:00:00');
    // 	}

    // 	if(isset($end) && $end)
    // 	{
    // 		$query->where($field, '<=', $end.' 23:59:59');
    // 	}
    // }

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
