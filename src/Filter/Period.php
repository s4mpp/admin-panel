<?php

namespace S4mpp\AdminPanel\Filter;

class Period extends Filter
{
	protected string $alpine_expression = '{start: null, end: null}';

	public function render()
	{
		return view('admin::filter.period', ['filter' => $this]);
	}

	public function query($term, $query)
	{
		$query->where(function($query) use ($term)
		{
			if(isset($term['start']) && $term['start'])
			{
				$query->where($this->getField(), '>=', $term['start'].' 00:00:00');
			}

			if(isset($term['end']) && $term['end'])
			{
				$query->where($this->getField(), '<=', $term['end'].' 23:59:59');
			}
		});
	}

	public function getDescriptionResult($term)
	{
		$start = $term['start'] ?? null;
		$end = $term['end'] ?? null;

		if($start && !$end)
		{
			$description = 'a partir de '.date('d/m/Y', strtotime($start));
		}
		else if(!$start && $end)
		{
			$description = 'até '.date('d/m/Y', strtotime($end));
		}
		else if($start && $end)
		{
			$description = date('d/m/Y', strtotime($start)).' a '.date('d/m/Y', strtotime($end));
		}

		return $description ?? null;
	}
}