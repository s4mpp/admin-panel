<?php

namespace S4mpp\AdminPanel\Resources;

use S4mpp\Laraguard\Base\Panel;
use S4mpp\Laraguard\Base\Module;
use S4mpp\AdminPanel\Input\Input;
use S4mpp\AdminPanel\Labels\Label;
use S4mpp\AdminPanel\Utils\Finder;
use S4mpp\AdminPanel\Column\Column;
use S4mpp\AdminPanel\Filter\Filter;
use S4mpp\AdminPanel\Labels\Actions;
use S4mpp\AdminPanel\Reports\Report;
use S4mpp\AdminPanel\Traits\Slugable;
use S4mpp\AdminPanel\Traits\Titleable;
use S4mpp\AdminPanel\Elements\Repeater;
use S4mpp\AdminPanel\ItemView\ItemView;
use S4mpp\AdminPanel\CustomActions\CustomAction;
use S4mpp\AdminPanel\Factories\Filter as FilterFactory;
use S4mpp\Laraguard\Laraguard;

abstract class Resource
{
	use Slugable, Titleable;

	private $name;

	final public function __construct()
	{
		$this->createSlug($this->getTitle());

		$name = static::class;

		$path = explode('\\', $name);

		$this->name = str_replace('Resource', '', end($path));
	}

	final public function getColumns(): array
	{
		if(!method_exists($this, 'table'))
		{
			return [];
		}

		$columns = Finder::onlyOf($this->table(), Label::class);

		if($actions = $this->getActions())
		{
			foreach($actions as $action)
			{
				$routes_action[$action] = $this->getRouteName($action);
			}

			array_push($columns, (new Actions('Actions', 'id'))->setActions($routes_action));
		}

		return $columns;
	}

	public function getRegisters()
	{
		$model = $this->getModel();

		return $model::paginate();
	}
	
	// final public function getName(): string
	// {
	// 	return $this->name;
	// }

	// final public function getMenuOrder(): ?int
	// {
	// 	return $this->menu_order ?? null;
	// }

	// final public function getSection(): ?string
	// {
	// 	return $this->section ?? null;
	// }

	// final public function getRolesForAccess(): array
	// {
	// 	$roles = $this->roles ?? [];
		
	// 	if(empty($roles) && config('admin.strict_permissions'))
	// 	{
	// 		throw new \Exception('Resource "'.$this->getName().'" has no roles (using Strict Permissions)');
	// 	}

	// 	return $roles;
	// }

	// final public function getSearchFields(): ?array
	// {
	// 	return $this->search ?? null;
	// }

	// final public function getOrdenationField(): string
	// {
	// 	return $this->ordenation[0] ?? 'id';
	// }

	// final public function getOrdenationDirection(): string
	// {
	// 	return $this->ordenation[1] ?? 'DESC';
	// }

	// final public function getMessagePlaceholderSearch(): ?string
    // {
    //     if(!isset($this->search) || empty($this->search))
    //     {
    //         return null;
    //     }
		
	// 	$fields = array_values($this->search);

    //     if(count($fields) == 1)
    //     {
    //         return $fields[0];
    //     }
	        
	// 	$last_item = array_pop($fields);

	// 	return join(', ', $fields).' ou '.$last_item;
    // }

	final public function getRouteName(string $crud_action): string
	{
		return Laraguard::panel(Panel::current())->getRouteName(Module::current(), $crud_action);
	}

	// final public function getView(string $view, array $data = [])
	// {		
	// 	return view('admin::crud.'.$view, array_merge($data, [
	// 		'title' => $this->title,
	// 	]));
	// }

	final public function getActions(): array
	{
		return $this->actions ?? [];
	}

	final public function hasAction(string $action)
	{
		return in_array($action, $this->actions ?? []);
	}
	
	// final public function getDefaultRoute(): ?string
	// {
	// 	if($this->hasAction('read'))
	// 	{
	// 		return $this->getRouteName('read');
	// 	}
	// 	else if($this->hasAction('update'))
	// 	{
	// 		return $this->getRouteName('update');
	// 	}

	// 	return null;
	// }

	final public function getName(): string
	{
		return $this->name;
	}
	
	final public function getNameModel()
	{
		return '\App\Models\\'.$this->name;
	}

	final public function getModel()
	{
		return app($this->getNameModel());
	}

	final public function getForm(): ?array
	{
		if(!method_exists($this, 'form'))
		{
			return null;
		}

		return Finder::onlyOf($this->form(), Input::class);
	}

	final public function getRead(): ?array
	{
		if(!method_exists($this, 'read'))
		{
			return null;
		}

		return Finder::onlyOf($this->read(), Label::class);
	}

	// final public function getTable(): ?array
	// {
	// 	if(!method_exists($this, 'table'))
	// 	{
	// 		return null;
	// 	}

	// 	return Utils::getOnlyOf($this->table(), Column::class);
	// }

	final public function getRepeaters(): array
	{
		if(!method_exists($this, 'repeaters'))
		{
			return [];
		}

		return Finder::onlyOf($this->repeaters(), Repeater::class);

		// foreach(Finder::onlyOf($this->repeaters(), Repeater::class) as $repeater)
		// {
		// 	$repeater->setRelationShipMethod($this->getModel()->{$repeater->getRelation()}());

		// 	$repeaters[$repeater->getRelation()] = $repeater;
		// }

		// return $repeaters ?? [];
	}

	// final public function getFilters(): array
    // {
    //     if(method_exists($this, 'filter'))
    //     {
	// 		foreach($this->filter() as $filter)
	// 		{
	// 			$filters[$filter->getField()] = $filter;
	// 		}
    //     }

	// 	foreach(Utils::getOnlyOf($filters ?? [], Filter::class) as $filter)
	// 	{
	// 		$filters[$filter->getField()] = $filter;
	// 	}

	// 	if($this->getModel()->timestamps)
    //     {
    //         $filters['created_at'] = FilterFactory::period('Cadastrado em', 'created_at');
    //     }

	// 	return $filters ?? [];
    // }


	final public function getCustomActions()
	{
		if(!method_exists($this, 'customActions'))
		{
			return [];
		}

		return Finder::onlyOf($this->customActions(), CustomAction::class);
	}

	final public function getReports(): ?array
	{
		if(!method_exists($this, 'reports'))
		{
			return null;
		}

		return Finder::onlyOf($this->reports(), Report::class);
	}

	final public function getReport(string $slug_report): ?Report
	{
		foreach($this->getReports() as $report)
        {
            if($report->getSlug() == $slug_report)
            {
                return $report;
            }
        }

		return null;
	}
}