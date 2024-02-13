<?php

namespace S4mpp\AdminPanel\Labels;


final class Relation extends Label
{
	// private $resource;

	// private string $field_main;

	// function __construct(private string $title, private string $field, string $resource, ?string $field_main = 'id')
	// {
	// 	$resource_name_exp = explode('\\', $resource);

	// 	$this->resource = new $resource(end($resource_name_exp));
		
	// 	$this->field_main = $this->_getMainFieldName($field_main);

	// 	parent::__construct($title, $field);
	// }

	// public function getRoute(): ?string
	// {
	// 	return $this->resource->getDefaultRoute();
	// }

	// public function renderView($value, $register)
	// {
	// 	$item = $this;

	// 	return view('admin::item-view.relation', compact('value', 'item', 'register'));
	// }

	// public function getId(Model $register)
	// {
	// 	return $this->undotPath($register, $this->field_main);
	// }

	// private function _getMainFieldName()
	// {
	// 	$path = explode('.', $this->field);

	// 	array_pop($path);

	// 	array_push($path, 'id');

	// 	return join('.', $path);
	// }
}