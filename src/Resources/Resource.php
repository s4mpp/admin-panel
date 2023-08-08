<?php

namespace S4mpp\AdminPanel\Resources;

use Illuminate\Support\Str;
use S4mpp\AdminPanel\Form\Form;
use S4mpp\AdminPanel\Table\Table;
use S4mpp\AdminPanel\Table\Action;

abstract class Resource
{
	public static $resources = array();

	public $model;

	public $name;
	
	public $title;
	
	public function __construct(public string $resource_name)
	{
		$model = '\App\Models\\'.$resource_name;

		$this->model = app($model);

		$this->name = Str::plural(strtolower($resource_name));
		
		$this->title = $this->title ?? Str::plural($resource_name);

		$this->table = $this->model->getTable();
	}

	public static function loadResource(Resource $resource)
	{
		self::$resources[] = $resource;
	}

	public static function getResources(): array
	{
		return self::$resources;
	}

	public function table()
	{
		$table = new Table($this->model::paginate());

		foreach($this->actions as $action)
		{
			switch($action)
			{
				case 'update':
					$actions_table[] = Action::update();
					break;

				case 'read':
					$actions_table[] = Action::read();
					break;

				case 'delete':
					$actions_table[] = Action::delete();
					break;
			}

		}

		if(isset($actions_table))
		{
			$table->actions($actions_table);
		}

		return $table;
	}

	public function form(int $id = null)
	{
		$form = new Form(($id) ? $this->model::find($id) : null);

		return $form;
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
}