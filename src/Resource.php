<?php

namespace S4mpp\AdminPanel;

use S4mpp\AdminPanel\Input\Input;
use S4mpp\AdminPanel\Column\Column;
use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Filter\Filter;
use S4mpp\AdminPanel\Traits\Slugable;
use S4mpp\AdminPanel\Traits\Titleable;
use S4mpp\AdminPanel\Elements\Repeater;
use S4mpp\AdminPanel\ItemView\ItemView;
use S4mpp\AdminPanel\CustomActions\CustomAction;
use S4mpp\AdminPanel\Factories\Filter as FilterFactory;

abstract class Resource
{
	use Slugable, Titleable;

	final public function __construct(private string $name)
	{
		$this->createSlug($this->getTitle());

		$this->name = str_replace(['Resource', '.php'], '', $name);
	}
	
	final public function getName(): string
	{
		return $this->name;
	}

	final public function getMenuOrder(): ?int
	{
		return $this->menu_order ?? null;
	}

	final public function getSection(): ?string
	{
		return $this->section ?? null;
	}

	final public function getRolesForAccess(): array
	{
		$roles = $this->roles ?? [];
		
		if(empty($roles) && config('admin.strict_permissions'))
		{
			throw new \Exception('Resource "'.$this->getName().'" has no roles (using Strict Permissions)');
		}

		return $roles;
	}

	final public function getSearchFields(): ?array
	{
		return $this->search ?? null;
	}

	final public function getOrdenationField(): string
	{
		return $this->ordenation[0] ?? 'id';
	}

	final public function getOrdenationDirection(): string
	{
		return $this->ordenation[1] ?? 'DESC';
	}

	final public function getMessagePlaceholderSearch(): ?string
    {
        if(!isset($this->search) || empty($this->search))
        {
            return null;
        }
		
		$fields = array_values($this->search);

        if(count($fields) == 1)
        {
            return $fields[0];
        }
	        
		$last_item = array_pop($fields);

		return join(', ', $fields).' ou '.$last_item;
    }

	final public function getRouteName(string $crud_action): string
	{
		return 'admin.'.$this->name.'.'.$crud_action;
	}

	final public function getView(string $view, array $data = [])
	{		
		return view('admin::crud.'.$view, array_merge($data, [
			'title' => $this->title,
		]));
	}

	final public function getActions()
	{
		return $this->actions ?? [];
	}

	final public function hasAction(string $action)
	{
		return in_array($action, $this->actions ?? []);
	}
	
	final public function getDefaultRoute(): ?string
	{
		if($this->hasAction('read'))
		{
			return $this->getRouteName('read');
		}
		else if($this->hasAction('update'))
		{
			return $this->getRouteName('update');
		}

		return null;
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

		return Utils::getOnlyOfThisOrCard($this->form(), Input::class);
	}

	final public function getRead(): ?array
	{
		if(!method_exists($this, 'read'))
		{
			return null;
		}

		return Utils::getOnlyOfThisOrCard($this->read(), ItemView::class);
	}

	final public function getTable(): ?array
	{
		if(!method_exists($this, 'table'))
		{
			return null;
		}

		return Utils::getOnlyOf($this->table(), Column::class);
	}

	final public function getRepeaters(): array
	{
		if(!method_exists($this, 'repeaters'))
		{
			return [];
		}

		foreach(Utils::getOnlyOf($this->repeaters(), Repeater::class) as $repeater)
		{
			$repeater->setRelationShipMethod($this->getModel()->{$repeater->getRelation()}());

			$repeaters[$repeater->getRelation()] = $repeater;
		}

		return $repeaters ?? [];
	}

	final public function getFilters(): array
    {
        if($this->getModel()->timestamps)
        {
            $filters['created_at'] = FilterFactory::period('Período', 'created_at');
        }

        if(method_exists($this, 'filter'))
        {
			foreach($this->filter() as $filter)
			{
				$filters[$filter->getField()] = $filter;
			}
        }

		foreach(Utils::getOnlyOf($filters ?? [], Filter::class) as $filter)
		{
			$filters[$filter->getField()] = $filter;
		}

		return $filters ?? [];
    }

	final public function getCustomActions()
	{
		if(!method_exists($this, 'customActions'))
		{
			return [];
		}

		return Utils::getOnlyOf($this->customActions(), CustomAction::class);
	}
}