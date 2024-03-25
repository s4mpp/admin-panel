<?php

namespace S4mpp\AdminPanel\Resources;

use S4mpp\Laraguard\Laraguard;
use S4mpp\Laraguard\Base\Panel;
use S4mpp\AdminPanel\AdminPanel;
use S4mpp\Laraguard\Base\Module;
use S4mpp\AdminPanel\Input\Input;
use S4mpp\AdminPanel\Enums\Action;
use S4mpp\AdminPanel\Labels\Label;
use S4mpp\AdminPanel\Utils\Finder;
use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Filter\Filter;
use Illuminate\Support\Facades\Auth;
use S4mpp\AdminPanel\Elements\Report;
use S4mpp\AdminPanel\Traits\Slugable;
use S4mpp\AdminPanel\Traits\Ordenable;
use S4mpp\AdminPanel\Traits\Titleable;
use Illuminate\Database\Eloquent\Model;
use S4mpp\AdminPanel\Elements\Repeater;
use Illuminate\Pagination\LengthAwarePaginator;
use S4mpp\AdminPanel\CustomActions\CustomAction;
use S4mpp\AdminPanel\Factories\Filter as FilterFactory;

abstract class Resource
{
    use Ordenable, Slugable, Titleable;

    private string $name;

    private ?Action $current_action = null;

    // protected $actions = [];

    /**
     * @var array<string>
     */
    protected $search = [];

    final public function __construct()
    {
        $this->createSlug($this->getTitle() ?? 'Untitled');

        $name = static::class;

        $path = explode('\\', $name);

        $this->name = str_replace('Resource', '', end($path));
    }

    final public function setCurrentAction(Action $action): self
    {
        $this->current_action = $action;

        return $this;
    }

    final public function getCurrentAction(): ?Action
    {
        return $this->current_action;
    }

    final public function getName(): string
    {
        return $this->name;
    }

    // public function getRegisters(): LengthAwarePaginator
    // {
    //     $model = $this->getModel();

    //     return $model::paginate();
    // }

    // public function getRegister(int $id): ?Model
    // {
    //     $model = $this->getModel();

    //     return $model::find($id);
    // }

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

    /**
     * @return array<string>
     */
    final public function getSearchFields(): array
    {
        return $this->search;
    }

    // /**
    //  * @return array<string>
    //  */
    // final public function getOrdenation(): array
    // {
    //     return [$this->ordenation_field => $this->ordenation_direction];
    // }

    final public function getMessagePlaceholderSearch(): ?string
    {
        if (empty($this->search)) {
            return null;
        }

        $fields = array_values($this->search);

        $message = 'Pesquisar por ';

        if (count($fields) == 1) {
            return $message.$fields[0];
        }

        $last_item = array_pop($fields);

        return $message.implode(', ', $fields).' ou '.$last_item;
    }

    final public function getRouteName(string $crud_action): ?string
    {
        $current_module = Module::current();

        $current_panel = Panel::current();

        return ($current_module) ? Laraguard::getPanel($current_panel)?->getRouteName($current_module, $crud_action) : null;
    }

    /**
     * @return array<string>
     */
    final public function getRouteActions(): array
    {
        foreach ($this->getActions() as $action) {
            $route_name = $this->getRouteName($action);

            if (! $route_name) {
                continue;
            }

            if(!Auth::guard(AdminPanel::getGuardName())->user()->can($this->getName().'.'.$action))
            {
                continue;
            }

            $actions[$action] = $route_name;
        }

        return $actions ?? [];
    }

    /** 
     * @return array<string>
     */
    final public function getAvailablePermissions(): array
    {
        $permissions[] = $this->getName();

        foreach ($this->getActions() as $action) {
            $permissions[] = $this->getName().'.action.'.$action;
        }

        foreach ($this->getCustomActions() as $custom_action) {
            $permissions[] = $this->getName().'.custom-action.'.$custom_action->getSlug();
        }
        foreach ($this->getReports() as $report) {
            $permissions[] = $this->getName().'.report.'.$report->getSlug();
        }

        return $permissions;
    }

    // final public function getView(string $view, array $data = [])
    // {
    // 	return view('admin::crud.'.$view, array_merge($data, [
    // 		'title' => $this->title,
    // 	]));
    // }

    /**
     * @return array<string>
     */
    final public function getActions(): array
    {
        return $this->actions ?? [];
    }

    final public function hasAction(string $action): bool
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

    // final public function getName(): string
    // {
    //     return $this->name;
    // }

    final public function getNameModel(): string
    {
        return config('admin.namespace', '\App').'\\Models\\'.$this->name;
    }

    final public function getModel(): Model
    {
        $model = $this->getNameModel();

        if (! class_exists($model)) {
            throw new \Exception('Model "'.$model.'" not found');
        }

        /** @var Model */
        return app($model);
    }

    // /**
    //  * @return array<Label>
    //  */
    // final public function getColumns(): array
    // {
    //     $columns = Finder::onlyOf($this->table(), Label::class);

    //     if ($actions = $this->getActions()) {
    //         foreach ($actions as $action) {
    //             $routes_action[$action] = $this->getRouteName($action);
    //         }
    //     }

    //     return $columns;
    // }

    /**
     * @return array<Input|Card>
     */
    final public function getForm(): array
    {
        /** @var array<Input|Card> */
        return Finder::onlyOf($this->form(), Input::class, Card::class);
    }

    /**
     * @return array<Label|Card>
     */
    final public function getRead(): array
    {
        /** @var array<Label|Card> */
        return Finder::onlyOf($this->read(), Label::class, Card::class);
    }

    /**
     * @return array<CustomAction>
     */
    final public function getCustomActions(): array
    {
        /** @var array<CustomAction> */
        return Finder::onlyOf($this->customActions(), CustomAction::class);
    }

    /**
     * @return array<Filter>
     */
    final public function getFilters(): array
    {
        /** @var array<Filter> */
        return Finder::onlyOf($this->filters(), Filter::class);
    }

    /**
     * @return array<Report>
     */
    final public function getReports(): array
    {
        /** @var  array<Report> */
        return Finder::onlyOf($this->reports(), Report::class);
    }

    /**
     * @return array<Label>
     */
    final public function getTable(): array
    {
        /** @var array<Label> */
        return Finder::onlyOf($this->table(), Label::class);
    }

    /**
     * @return array<Repeater>
     */
    final public function getRepeaters(): array
    {
        /** @var array<Repeater> */
        return Finder::onlyOf($this->repeaters(), Repeater::class);
    }

    

    // /**
    //  * @return array<Label|Card>
    //  */
    // final public function getRead(): array
    // {
    //     return Finder::onlyOf($this->read(), Label::class, Card::class);
    // }

    // /**
    //  * @return array<Repeater>
    //  */
    // final public function getRepeaters(): array
    // {
    //     return Finder::onlyOf($this->repeaters(), Repeater::class);

    //     // foreach(Finder::onlyOf($this->repeaters(), Repeater::class) as $repeater)
    //     // {
    //     // 	$repeater->setRelationShipMethod($this->getModel()->{$repeater->getRelation()}());

    //     // 	$repeaters[$repeater->getRelation()] = $repeater;
    //     // }

    //     // return $repeaters ?? [];
    // }

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

    // /**
    //  * @return array<CustomAction>
    //  */
    // final public function getCustomActions(): array
    // {
    //     return Finder::onlyOf($this->customActions(), CustomAction::class);
    // }

    // /**
    //  * @return array<Report>
    //  */
    // final public function getReports(): array
    // {
    //     return Finder::onlyOf($this->reports(), Report::class);
    // }

    // final public function getReport(string $slug_report): ?Report
    // {
    //     return Finder::findBySlug(Finder::findElementsRecursive($this->reports(), Report::class), $slug_report);
    // }

    

    // final public function getCustomAction(string $slug_custom_action): ?Report
    // {
    //     foreach ($this->customActions() as $cusom_action) {
    //         if ($cusom_action->getSlug() == $slug_custom_action) {
    //             return $cusom_action;
    //         }
    //     }

    //     return null;
    // }

    /**
     * @return array<Filter>
     */
    protected function filters(): array
    {
        return [];
    }

    /**
     * @return array<Label|Card>
     */
    protected function table(): array
    {
        return [];
    }

    /**
     * @return array<Input|Card>
     */
    protected function form(): array
    {
        return [];
    }

    /**
     * @return array<Label|Card>
     */
    protected function read(): array
    {
        return [];
    }

    /**
     * @return array<Repeater>
     */
    protected function repeaters(): array
    {
        return [];
    }

    /**
     * @return array<CustomAction>
     */
    protected function customActions(): array
    {
        return [];
    }

    /**
     * @return array<Report>
     */
    protected function reports(): array
    {
        return [];
    }
}
