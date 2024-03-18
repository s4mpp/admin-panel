<?php

namespace S4mpp\AdminPanel\Livewire;

use Livewire\Component;
use Livewire\Redirector;
use S4mpp\AdminPanel\Utils;
use S4mpp\AdminPanel\Input\Input;
use S4mpp\AdminPanel\Input\Search;
use S4mpp\AdminPanel\Utils\Finder;
use Illuminate\Contracts\View\View;
use Illuminate\Support\ValidatedInput;
use S4mpp\AdminPanel\Hooks\CreateHook;
use S4mpp\AdminPanel\Hooks\UpdateHook;
use Illuminate\Database\Eloquent\Model;
use S4mpp\AdminPanel\Elements\Repeater;
use S4mpp\AdminPanel\Resources\Resource;
use S4mpp\AdminPanel\Traits\CreatesForm;
use S4mpp\AdminPanel\Traits\CanHaveSubForm;
use S4mpp\AdminPanel\Traits\WithAdminResource;
use Illuminate\Contracts\View\Factory as ViewFactory;

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

    public string $route_index;

    /**
     * @var array<int,string,null>
     */
    public array $childs = [];

    private array $repeater_tables = [];

    public ?int $id_register = null;

    protected $listeners = ['setChild'];

    /**
     * @param  array<mixed>|null  $register
     */
    public function mount(Resource $resource, ?array $register = null): void
    {
        $this->resource_slug = $resource->getSlug();

        $this->resource = $resource;

        $this->route_index = $resource->getRouteName('index');

        $this->id_register = $register ? $register['id'] : null;

        $this->loadResource();

        $this->form = Finder::fillInCard($this->resource->form());

        $this->setData($register);

        $this->repeaters = Finder::onlyOf($this->resource->repeaters(), Repeater::class);

        foreach ($this->repeaters ?? [] as $repeater) {
            $this->childs[$repeater->getRelation()] = [];
        }
    }

    public function booted(): void
    {
        $this->loadResource();

        $this->form = Finder::fillInCard($this->resource->form());

        $this->repeaters = Finder::onlyOf($this->resource->repeaters(), Repeater::class);

        $this->loadRepeaterValues();
    }

    public function render(): View|ViewFactory
    {
        return view('admin::livewire.form', [
            'repeaters' => $this->repeaters ?? [],
        ]);
    }

    public function save(): ?Redirector
    {
        $this->resetValidation();

        $fields = Finder::findElementsRecursive($this->form, Input::class);

        $fields_validated = $this->_validate($fields);

        try {
            $register = $this->_prepareData($fields, $fields_validated);

            $register->save();

            session()->flash('message', 'Registro salvo com sucesso!');

            return redirect()->route($this->route_index);
        } catch (\Exception $e) {
            $this->addError('exception', $e->getMessage());

            $this->dispatchBrowserEvent('reset-loading');

            return null;
        }
    }

    public function setChild(string $relation, ?int $id_temp, ?int $register_id, array $data_to_save): void
    {
        if (isset($this->childs[$relation][$id_temp])) {
            $this->childs[$relation][$id_temp]['data'] = $data_to_save;
        } else {
            $this->childs[$relation][$id_temp ?? rand()] = ['id' => $register_id, 'data' => $data_to_save];
        }

        $this->loadRepeaterValues();
    }

    public function loadRepeaterValues(): void
    {
        foreach ($this->childs as $relation => $child) {
            if ($this->id_register) {
                $model = $this->resource->getModel();

                $register = $model::find($this->id_register);

                $data = $register->{$relation};

                $data = $data->each(function ($item) use ($child) {
                    $childs_changed = array_filter($child ?? [], fn ($c) => ($c['id'] ?? null) == $item['id']);

                    $child_changed = current($childs_changed);

                    if (! empty($child_changed)) {
                        foreach ($child_changed['data'] ?? [] as $key => $value) {
                            $item[$key] = $value;
                        }

                        $item['id_temp'] = key($childs_changed);
                    } else {
                        $item['id_temp'] = rand();
                    }

                    return $item;
                });
            } else {
                $data = collect([]);
            }

            $childs_added = array_filter($child ?? [], fn ($data) => is_null($data['id'] ?? null));

            foreach ($childs_added as $id_temp => $item) {
                $new_item = collect($item['data']);

                $new_item['id_temp'] = $id_temp;

                $data->push($new_item);
            }

            $this->repeater_tables[$relation] = $data;
        }
    }

    private function _getTable(): string
    {
        return $this->resource->getModel()->getTable();
    }

    /**
     * @param  array<Input>  $fields
     * @param  ValidatedInput|array<string>  $fields_validated
     */
    private function _prepareData(array $fields, ValidatedInput|array $fields_validated): Model
    {
        $model = $this->resource->getModel();

        $register = ($this->id_register) ? $model::find($this->id_register) : new $model();

        foreach ($fields as $field) {
            $data = $fields_validated[$field->getName()] ?? null;

            // if(is_a($field, File::class))
            // {
            // 	if(!is_a($data, TemporaryUploadedFile::class))
            // 	{
            // 		continue;
            // 	}

            // 	$value = $this->_uploadFile($field, $data);
            // }
            // else
            // {
            $value = $data ?? null;
            // }

            $register->{$field->getName()} = $value;
        }

        return $register;
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

    /**
     * @param  ValidatedInput|array<string>  $fields_validated
     */
    // private function _saveData(Model $register, ValidatedInput|array $fields_validated): Redirector
    // {
    // 	// $hook = (!$this->register) ? CreateHook::class : Updatehook::class;

    // 	// $hook::before($this->resource, $register, $fields_validated);

    // 	$register->save();

    // 	// $hook::after($this->resource, $register, $fields_validated);

    // 	// $this->_saveChilds($register);

    // 	session()->flash('message', 'Registro salvo com sucesso!');

    // 	return redirect()->route($this->route_index);
    // }
}
