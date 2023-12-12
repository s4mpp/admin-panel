<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Input\Input;

final class Search extends Input
{
	function __construct(
		private string $title,
		private string $name,
		private string $relationship,
		private ?string $model_field = null)
	{
		parent::__construct($title, $name);
	}

	public function getRelationShip(): string
	{
		return $this->relationship;
	}

	public function getModelField(): string
	{
		return $this->model_field ?? 'id';
	}

	public function renderInput(array $data, $register)
	{
		return view('admin::input.search', [
			'input' => $this,
			'required' => $this->isRequired(),
			'data' => $data,
			'register' => $register
		]);
	}
}