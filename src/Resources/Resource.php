<?php

namespace S4mpp\AdminPanel\Resources;

use Illuminate\Support\Str;
use S4mpp\AdminPanel\Action\Action;

abstract class Resource
{
	public static $resources = array();

	public $model;
	
	public $controller;

	public $name;
	
	public $title;
	
	public function __construct(public string $resource_name)
	{
		$this->model = app('\App\Models\\'.$resource_name);
		
		$this->name = Str::plural(strtolower($resource_name));
		
		$this->title = !empty($this->title) ? $this->title : Str::plural($resource_name);
	}

	public function getCustomActions()
	{
		return [];
	}

	public function getController()
	{
		return '\App\Http\Controllers\\'.$this->resource_name.'Controller';
	}

	public static function loadResource(Resource $resource)
	{
		self::$resources[] = $resource;
	}

	public static function getResources(): array
	{
		return self::$resources;
	}

	public function getRouteName(string $action): string
	{
		return Str::lower($this->resource_name).'_'.$action.'_admin';
	}

	public function getRoutes(): array
	{
		$routes = [
			'index' => $this->getRouteName('index')
		];

		foreach($this->actions as $action)
		{
			$routes[$action] = $this->getRouteName($action);
		}

		if(in_array('update', $this->actions))
		{
			$routes['save'] = $this->getRouteName('save');
		}

		if(in_array('create', $this->actions))
		{
			$routes['store'] = $this->getRouteName('store');
		}

		$custom_actions = $this->getCustomActions();

		foreach($custom_actions as $action)
		{
			$routes[$action->slug] = $this->getRouteName($action->slug);
		}

		return $routes;
	}

	public function getView(string $view, array $data = [])
	{
		return view('admin::resources.'.$view, array_merge($data, [
			'title' => $this->title,
			'actions' => $this->actions,
			'action_routes' => $this->getRoutes(),
		]));
	}

	public function getActions()
	{
		$actions = [];

		foreach($this->actions as $action)
		{
			switch($action)
			{
				case 'update':
					$actions[] = Action::create('Editar', 'update')->icon('pencil');
					break;

				case 'read':
					$actions[] = Action::create('Visualizar', 'read')->icon('eye');
					break;

				case 'delete':
					$actions[] = Action::create('Excluir', 'delete')->icon('trash')->context('danger')->method('delete')->question('Tem certeza?');
					break;
			}
		}

		$actions = array_merge($actions, $this->getCustomActions());

		return $actions;
	}
}