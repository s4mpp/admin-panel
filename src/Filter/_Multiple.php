<?php

namespace S4mpp\AdminPanel\Filter;
use S4mpp\AdminPanel\Traits\WithSubOptions;

class Multiple extends Filter
{
	// use WithSubOptions;

	// public function render()
	// {
	// 	return view('admin::filter.multiple', ['filter' => $this]);
	// }

	// public function getInitialValue(): array
	// {
	// 	return [];
	// }

	// /**
	//  * @deprecated
	//  */
	// public function filter($term, $query)
	// {
		
	// 	self::query($query, $this->getField(), array_values($term));
	// }
	
	// public static function query($query, string $field, array $values)
	// {
	// 	if(empty($values))
	// 	{
	// 		return;
	// 	}
		
	// 	$query->whereIn($field, $values);
	// }

	// public function getDescriptionResult($term)
	// {
	// 	$term = array_filter($term);
	
	// 	$options = $this->getOptions();

	// 	foreach($options as $key => $value)
	// 	{
	// 		if(in_array($key, $term))
	// 		{
	// 			$description[] = $value;
	// 		}
	// 	}

	// 	return join(', ', $description ?? []);
	// }
}