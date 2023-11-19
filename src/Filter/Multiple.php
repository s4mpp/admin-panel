<?php

namespace S4mpp\AdminPanel\Filter;
use S4mpp\AdminPanel\Traits\WithSubOptions;

class Multiple extends Filter
{
	use WithSubOptions;

	protected string $alpine_expression = '[]';

	public function render()
	{
		return view('admin::filter.multiple', ['filter' => $this]);
	}

	public function query($term, $query)
	{
		$query->whereIn($this->getField(), array_values($term));
	}

	public function getDescriptionResult($term)
	{
		$term = array_filter($term);
	
		$options = $this->getOptions();

		foreach($options as $key => $value)
		{
			if(in_array($key, $term))
			{
				$description[] = $value;
			}
		}

		return join(', ', $description ?? []);
	}
}