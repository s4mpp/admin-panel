<?php

namespace S4mpp\AdminPanel\Livewire;

use Livewire\Component;
use S4mpp\AdminPanel\Utils;
use S4mpp\AdminPanel\Input\Search;
use S4mpp\AdminPanel\Utils\Finder;
use Illuminate\Support\ValidatedInput;
use S4mpp\AdminPanel\Hooks\CreateHook;
use S4mpp\AdminPanel\Hooks\UpdateHook;
use Illuminate\Database\Eloquent\Model;
use S4mpp\AdminPanel\Elements\Repeater;
use S4mpp\AdminPanel\Resources\Resource;
use S4mpp\AdminPanel\Traits\CreatesForm;
use S4mpp\AdminPanel\Traits\CanHaveSubForm;
use S4mpp\AdminPanel\Traits\WithAdminResource;

/**
 * @codeCoverageIgnore
 */
final class FormResource extends Component
{
    use CreatesForm, WithAdminResource;
    // use WithAdminResource, CreatesForm, CanHaveSubForm;

    /**
     * @var array<Repeater>
     */
    private array $repeaters = [];

    // /**
    //  * @var array<array>
    //  */
    // public array $childs = [];

    public ?int $id_register = null;

    // protected $listeners = ['setField', 'setChildField', 'setChildEmpty'];

    /**
     * @param  array<mixed>|null  $register
     */
    public function mount(Resource $resource, array $register = null): void
    {
        $this->resource_slug = $resource->getSlug();

        $this->resource = $resource;

        $this->id_register = $register ? $register['id'] : null;

        $this->setInitialData($this->resource->getForm(), $register);

        // 	$this->_setResource($resource_name);

        // 	$this->_setRepeaters();

        // 	$this->form = $this->resource->getForm();

        // $this->register = $this->resource->getRegister($id_register);

        // 	$this->_setInitialData();
    }

    public function booted(): void
    {
        $this->loadResource();

        $this->form = Finder::fillInCard($this->resource->getForm());

        $this->repeaters = $this->resource->getRepeaters();

        foreach ($this->repeaters as $repeater) {
            // $this->childs[$repeater->getRelation()] = $this->register ? $this->register->{$repeater->getRelation()} : collect([]);
        }
    }

    // public function booted()
    // {
    // 	$this->_setResource($this->resource_name);

    // 	$this->_setRepeaters();

    // 	$this->form = $this->resource->getForm();

    // 	// $this->_setSearchFields();
    // }

    // // private function _setSearchFields()
    // // {
    // // 	$repeaters_searchs = [];

    // // 	foreach($this->repeaters as $repeater)
    // // 	{
    // // 		$repeaters_search = Utils::findElement($repeater->getFields(), Search::class);

    // // 		foreach($repeaters_search as $search)
    // // 		{
    // // 			$search->setModel(get_class(app($repeater->getNameModelRelation())->customer()->getRelated()));

    // // 			$search->setRepeater($repeater->getRelation());
    // // 		}

    // // 		$repeaters_searchs = array_merge($repeaters_searchs, $repeaters_search);
    // // 	}

    // // 	$this->search_fields = array_merge($this->_getSearchFieldsForm(), $repeaters_searchs);
    // // }

    // private function _getModel()
    // {
    // 	return $this->resource->getModel();
    // }

    // private function _getRegister($register = null)
    // {
    // 	$model = $this->_getModel();

    // 	return $register ?? new $model;
    // }

    // private function _saving(Model $register, ValidatedInput $fields_validated)
    // {
    // 	$hook = (!$this->register) ? CreateHook::class : Updatehook::class;

    // 	$hook::before($this->resource, $register, $fields_validated);

    // 	$register->save();

    // 	$hook::after($this->resource, $register, $fields_validated);

    // 	$this->_saveChilds($register);

    // 	session()->flash('message', 'Registro salvo com sucesso!');

    // 	return redirect()->route($this->resource->getRouteName('index'));
    // }
}
