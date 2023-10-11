<?php

namespace S4mpp\AdminPanel\Resources;

use Illuminate\Support\Str;
use S4mpp\AdminPanel\Elements\Action;

abstract class Resource
{
	public static $resources = array();

	public $model;
	
	public $controller;

	public $name;
	
	public $title;

	public $slug;

	public $menu_order = null;

	public $ordenation = ['id', 'DESC'];
		
	public function __construct(public string $resource_name)
	{		
		$this->name = Str::plural(strtolower($resource_name));
		
		$this->title = !empty($this->title) ? $this->title : Str::plural($resource_name);
		
		$this->slug = Str::slug($this->title);
	}

	public function getModel()
	{
		return app('\App\Models\\'.$this->resource_name);
	}

	public static function add(Resource $resource)
	{
		self::$resources[$resource->name] = $resource;
	}

	public static function getResources(): array
	{
		return self::$resources;
	}

	public static function getResource(string $resource_name): Resource
	{
		return self::$resources[$resource_name];
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

		if(method_exists($this, 'getCustomActions'))
		{
			foreach($this->getCustomActions() ?? [] as $custom_action)
			{
				$routes[$custom_action->getSlug()] = $this->getRouteName($custom_action->getSlug());
			}
		}
		
		return $routes;
	}

	public function getView(string $view, array $data = [])
	{
		return view('admin::resources.'.$view, array_merge($data, [
			'title' => $this->title
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
					$actions['update'] = Action::create('Editar', 'update')->icon('pencil')->showIn(['read', 'table']);
					break;

				case 'read':
					$actions['read'] = Action::create('Visualizar', 'read')->icon('eye')->showIn(['update', 'table']);
					break;

				case 'delete':
					$actions['delete'] = Action::create('Excluir', 'delete')->icon('trash')->danger()->method('delete')->question('Tem certeza que deseja excluir este registro?');
					break;
			}
		}
	
		return $actions;
	}

	public function getCustomActionsResource($register)
	{
		if(!method_exists($this, 'getCustomActions'))
		{
			return null;
		}

		foreach($this->getCustomActions() ?? [] as $custom_action)
		{
			$actions[$custom_action->getSlug()] = $custom_action;
		}

		return $actions ?? [];
	}
}