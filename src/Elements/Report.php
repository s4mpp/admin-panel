<?php

namespace S4mpp\AdminPanel\Elements;

use S4mpp\AdminPanel\Filter\Filter;
use S4mpp\AdminPanel\Utils;
use S4mpp\AdminPanel\Traits\Slugable;
use S4mpp\AdminPanel\Traits\Titleable;

final class Report
{
	use Titleable, Slugable;

	private array $possible_results = [];

	function __construct(private string $title, private array $fields)
	{
		$this->createSlug($title);

		return $this;
	}

	public function result(string $title, string $model_method)
	{
		$this->possible_results[] = compact('title', 'model_method');

		return $this;
	}

	public function getFields(): array
	{
		return Utils::getOnlyOf($this->fields, Filter::class);
	}

	public function getPossibleResults(): array
	{
		return $this->possible_results;
	}

	public function getRouteName(string $resource): string
	{
		return 'admin.'.$resource.'.report.'.$this->slug;
	}
}