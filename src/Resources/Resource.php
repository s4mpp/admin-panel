<?php

namespace S4mpp\AdminPanel\Resources;

use Illuminate\Support\Str;
use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Elements\Action;
use S4mpp\AdminPanel\Navigation;
use S4mpp\AdminPanel\Navigation\MenuSection;
use S4mpp\AdminPanel\Traits\HasSlug;

abstract class Resource
{
	use HasSlug;

	private string $name;

	public function __construct(string $name)
	{
		$this->createSlug($this->getTitle());

		$this->name = str_replace(['Resource', '.php'], '', $name);
	}
	
	final public function getTitle()
	{
		return $this->title ?? 'No title';
	}

	final public function getSection(): ?string
	{
		if(!isset($this->section))
		{
			return null;
		}

		return $this->section;
	}

	final public function getTable(): ?array
	{
		if(!method_exists($this, 'table'))
		{
			return null;
		}

		return $this->table();
	}

	final public function getForm(): ?array
	{
		if(!method_exists($this, 'form'))
		{
			return null;
		}

		return $this->form();
	}

	final public function getRead(): ?array
	{
		if(!method_exists($this, 'read'))
		{
			return null;
		}

		return $this->read();
	}

	final public function getRouteName(string $crud_action): string
	{
		return 'admin.'.$this->getSlug().'.'.$crud_action;
	}

	final public function getView(string $view, array $data = [])
	{
		// $navigation = Navigation::getInstance();
		
		// $menu = $navigation->getMenu(); dump($menu);

		// $navigation->getSection($this->getSection())->getItems()[$this->getSlug()]->activate();
		
		return view('admin::crud.'.$view, array_merge($data, [
			'title' => $this->title,
			// 'navigation' => $menu
		]));
	}

	public function getActions()
	{
		return $this->actions ?? [];
	}

	public function hasAction(string $action)
	{
		return in_array($action, $this->actions ?? []);
	}

	public function getModel()
	{
		return app('\App\Models\\'.$this->name);
	}



























	
	// public static $resources = array();

	// public $model;
	
	// public $controller;

	// public $name;
	
	// // public $title;

	// // public $slug;

	// public $menu_order = null;

	// public $ordenation = ['id', 'DESC'];
	
	// // public function __construct(public string $resource_name)
	// // {		
	// // 	$this->name = Str::plural(strtolower($resource_name));
		
	// // 	$this->title = !empty($this->title) ? $this->title : Str::plural($resource_name);
		
	// // 	$this->slug = Str::slug($this->title);
	// // }

	// public function getOrder(): int
	// {
	// 	return $this->order ?? 0;
	// }

	// public function getModel()
	// {
	// 	return app('\App\Models\\'.$this->resource_name);
	// }

	// public static function add(Resource $resource)
	// {
	// 	self::$resources[$resource->name] = $resource;
	// }

	// public static function getResources(): array
	// {
	// 	return self::$resources;
	// }

	// public static function getResource(string $resource_name): Resource
	// {
	// 	return self::$resources[$resource_name];
	// }

	// public function getRouteName(string $action): string
	// {
	// 	return Str::lower($this->resource_name).'_'.$action.'_admin';
	// }

	// public function getDefaultRoute(): ?string
	// {
	// 	$default_action = in_array('read', $this->actions, 'read') ? 'read' : (in_array('update', $this->actions) ? 'update' : null);

	// 	return ($default_action) ? $this->getRouteName($default_action) : null;
	// }

	

	// // public function getRoutes(): array
	// // {
	// // 	$routes = [
	// // 		'index' => $this->getRouteName('index')
	// // 	];

	// // 	foreach($this->actions as $action)
	// // 	{
	// // 		$routes[$action] = $this->getRouteName($action);
	// // 	}

	// // 	if(in_array('update', $this->actions))
	// // 	{
	// // 		$routes['save'] = $this->getRouteName('save');
	// // 	}

	// // 	if(in_array('create', $this->actions))
	// // 	{
	// // 		$routes['store'] = $this->getRouteName('store');
	// // 	}
		
	// // 	return $routes;
	// // }

	// // public function getView(string $view, array $data = [])
	// // {
	// // 	return view('admin::resources.'.$view, array_merge($data, [
	// // 		'title' => $this->title
	// // 	]));
	// // }

	// // public function getActions()
	// // {
	// // 	$actions = [];

	// // 	foreach($this->actions as $action)
	// // 	{
	// // 		switch($action)
	// // 		{
	// // 			case 'update':
	// // 				// $actions['update'] = Action::create('Editar', 'update')->icon('pencil')->showIn(['read', 'table']);
	// // 				break;

	// // 			case 'read':
	// // 				// $actions['read'] = Action::create('Visualizar', 'read')->icon('eye')->showIn(['update', 'table']);
	// // 				break;

	// // 			case 'delete':
	// // 				// $actions['delete'] = Action::create('Excluir', 'delete')->icon('trash')->danger()->method('delete')->question('Tem certeza que deseja excluir este registro?');
	// // 				break;
	// // 		}
	// // 	}
	
	// // 	return $actions;
	// // }

	// // public function getCustomActionsResource($register)
	// // {
	// // 	if(!method_exists($this, 'getCustomActions'))
	// // 	{
	// // 		return [];
	// // 	}

	// // 	foreach($this->getCustomActions() ?? [] as $custom_action)
	// // 	{
	// // 		if(!$custom_action->checkPermissions())
	// // 		{
	// // 			continue;
	// // 		}

	// // 		$custom_action->setRegister($register);

	// // 		$actions[$custom_action->getSlug()] = $custom_action;
	// // 	}

	// // 	return $actions ?? [];
	// // }

	// public function getRepeatersResource(): array
	// {
	// 	if(!method_exists($this, 'getRepeaters'))
	// 	{
	// 		return [];
	// 	}

	// 	$repeaters = $this->getRepeaters();

	// 	foreach($repeaters as $repeater)
	// 	{
	// 		$arr[$repeater->getRelation()] = $repeater;
	// 	}

	// 	return $arr ?? [];
	// }
}