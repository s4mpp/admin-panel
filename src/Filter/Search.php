<?php

namespace S4mpp\AdminPanel\Filter;

class Search extends Filter
{
	function __construct(
		private string $title,
		private string $name,
		private string $relationship,
		private ?string $model_field = null)
	{
		parent::__construct($title, $name);
	}

	public function render()
	{
		return view('admin::filter.search', ['filter' => $this]);
	}

	public function filter($term, $query)
	{
		self::query($query, $this->getField(), $term);
	}

	public static function query($query, string $field, string | int $term = null)
	{
		if(!$term)
		{
			return;
		}
		
		$query->where($field, $term);
	}

	public function getDescriptionResult($term)
	{
		return $term;
		// $term = array_filter($term);
	
		// $options = $this->getOptions();

		// foreach($options as $key => $value)
		// {
		// 	if(in_array($key, $term))
		// 	{
		// 		$description[] = $value;
		// 	}
		// }

		// return join(', ', $description ?? []);
	}
}