<?php

namespace S4mpp\AdminPanel\Table;

class Action
{
	public bool $has_confirmation = false;

	function __construct(public string $label, public string $icon, public string $context, public string $route)
	{}

	public static function update()
	{
		return new Action('Editar', 'pencil', 'primary', 'update');
	}

	public static function read()
	{
		return new Action('Visualizar', 'eye', 'primary', 'read');
	}

	public static function delete()
	{
		$delete = new Action('Excluir', 'trash', 'danger', 'delete');

		$delete->confirm();

		return $delete;
	}

	public function confirm()
	{
		$this->has_confirmation = true;
	}
}