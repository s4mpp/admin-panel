<?php

namespace S4mpp\AdminPanel\ItemView;

use S4mpp\AdminPanel\ItemView\ItemView;
use S4mpp\AdminPanel\Resource;

final class Relation extends ItemView
{
	private $resource;

	function __construct(private string $title, private string $field, string $resource)
	{
		$resource_name_exp = explode('\\', $resource);

		$this->resource = new $resource(end($resource_name_exp));

		parent::__construct($title, $field);
	}

	public function getRoute()
	{
		return $this->resource->getDefaultRoute();
	}

	public function renderView($value, $register)
	{
		$item = $this;

		return view('admin::item-view.relation', compact('value', 'item', 'register'));
	}
}