<?php

namespace S4mpp\AdminPanel\Filter;
use Illuminate\Support\Collection;
use S4mpp\AdminPanel\Traits\WithSubOptions;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class Multiple extends Filter
{
	use WithSubOptions;

	protected string $alpine_expression = '[]';

	function __construct(
		private string $title,
		private string $name,
		array | Collection | EloquentCollection $options = [],
		string $value_collection = null,
		string $key_collection = null)
	{
		$this->options = $options;
		$this->value_collection = $value_collection;
		$this->key_collection = $key_collection;
		
		parent::__construct($title, $name);
	}

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