<?php

namespace S4mpp\AdminPanel\Livewire;

use Livewire\Component;
use App\Models\Participant;
use Illuminate\Validation\Rule;
use S4mpp\AdminPanel\Elements\Field;
use S4mpp\AdminPanel\Hooks\UpdateHook;
use S4mpp\AdminPanel\Resources\Resource;
use Illuminate\Support\Facades\Validator;
use Livewire\WithFileUploads;

class Form extends Component
{
	use WithFileUploads;

	public string $resource_name;
	
	public ?int $register_id = null;
	
	public $register;
	
	public array $data = [];

	public array $child_data = [];
	
	public array $childs = [];

	public array $child_id = [];
	
	private $resource;

	private $form;

	private $repeaters = [];

    public function mount(string $resource_name, int $id = null)
    {
        $this->resource_name = $resource_name;

		$this->register_id = $id;

		$this->resource = Resource::getResource($this->resource_name);

		$this->form = self::_getForm($this->resource);

		$this->register = ($this->register_id) ? $this->resource->getModel()->findOrFail($this->register_id) : null;

		$fields = $this->_getFields();

		foreach($fields as $field)
		{
			$value = $this->register?->{$field->getName()} ?? null;

			$default_value = (!is_null($field) && is_null($value) ? $field->getDefaultText() : null);

			if($field->getType() == 'date')
			{
				$this->data[$field->getName()] = $value ? $value->format('Y-m-d') : $default_value;
			}
			else
			{
				$this->data[$field->getName()] = $value ?? $default_value;
			}
		}

		$this->repeaters = $this->resource->getRepeatersResource();

		foreach($this->repeaters as $repeater)
		{
			$this->childs[$repeater->getRelation()] = $this->register ?
				$this->register->{$repeater->getRelation()}->toArray()
			: [];
		}
    }

    public function booted()
    {
        $this->resource = Resource::getResource($this->resource_name);

		$this->form = self::_getForm($this->resource);

		$this->repeaters = $this->resource->getRepeatersResource();
    }

    public function render()
    {        
        return view('admin::livewire.form', ['repeaters' => $this->repeaters]);
    }

	public function setChild(string $relation, int $i)
	{
		$this->child_id[$relation] = $i;

		$this->child_data[$relation] = $this->childs[$relation][$i];
	}

	public function saveChild(string $relation)
	{
		try
		{
			$repeater = $this->repeaters[$relation];

			$data = [];

			foreach($repeater->getFields() as $field)
			{
				$data[$field->name] = $this->child_data[$relation][$field->name];
			}

			$child_id_relation = $this->child_id[$relation] ?? null;

			if(is_numeric($child_id_relation))
			{
				$this->childs[$relation][$child_id_relation] = $data;
			}
			else
			{
				$this->childs[$relation][] = $data;
			}

			$this->reset('child_data', 'child_id');
			$this->dispatchBrowserEvent('close-slide');
		}
		catch (\Exception $e)
		{
			$this->addError('exception', $e->getMessage());
		}
		finally
		{
			$this->dispatchBrowserEvent('reset-form');
		}
	}

	public function save()
	{
		$this->resetValidation();

		try
		{
			$fields = $this->_getFields();

			$fields_validated = $this->_validate($fields, $this->resource->getModel()->getTable());

			$model = $this->resource->getModel();

			$register = ($this->register_id) ? $model->findOrFail($this->register_id) : new $model();

			foreach($fields as $field)
			{
				if($field->getType() == 'file')
				{
					$register->{$field->getName()} = $fields_validated[$field->getName()]->storePublicly('documents');
				}
				else
				{
					$register->{$field->getName()} = $fields_validated[$field->getName()] ?? null;
				}

			}
		
			// UpdateHook::before($this->resource, $register, $fields_validated);
			
			$register->save();
			
			// UpdateHook::after($this->resource, $register, $fields_validated);

			$this->_saveChilds($register);
						
			session()->flash('message', 'Alteração realizada com sucesso!');
	
			return redirect()->route($this->resource->getRouteName('index'));
		}
		catch(\Exception $e)
		{
			$this->addError('exception', $e->getMessage());
			
			$this->dispatchBrowserEvent('reset-form');
		}
	}

	private function _saveChilds($register)
	{
		foreach($this->repeaters as $repeater)
		{
			$relation = $repeater->getRelation();

			$model = $register->{$relation}()->getRelated();

			$childs_to_save = [];
			
			foreach($this->childs[$relation] ?? [] as $child)
			{
				$child_to_save = (isset($child['id']) && $child['id']) ? $model::find($child['id']) : new $model();

				foreach($child as $key => $field)
				{
					$child_to_save->{$key} = $field;
				}

				$childs_to_save[] = $child_to_save;
			}

			$register->{$relation}()->saveMany($childs_to_save);
		}
	}

	private static function _getForm($resource, int $id = null)
	{
		throw_if(!method_exists($resource, 'getForm'), 'Método getForm não existe.');
						
		return $resource->getForm($id);
	}

	private function _getFields(): array
	{
		return self::_findFields($this->form, []);
	}

	private static function _findFields(array $elements, array $fields_found): array
	{
		foreach($elements as $element)
		{
			if(is_a($element, Field::class))
			{
				$fields_found[] = $element;
			}
			else
			{
				$fields_found = self::_findFields($element->getElements(), $fields_found);
			}
		}

		return $fields_found;
	}

	private function _validate(array $fields, string $table)
	{
		$validation_rules = $attributes = [];

		foreach($fields as $field)
		{
			if($field->getPrepareForValidation())
			{
				$this->data[$field->name] = call_user_func($field->getPrepareForValidation(), $this->data[$field->name]);
			}

			$rules = [];
			foreach($field->getRules() as $rule)
			{
				switch($rule)
				{
					case 'unique':
						$rules[] = Rule::unique($table)->ignore($this->register_id);
						break;
						
					default:
						$rules[] = $rule;	
				}
			}

			$validation_rules[$field->getName()] = $rules;

			$attributes[$field->getName()] = $field->getTitle();
		}

		$validator = Validator::make($this->data, $validation_rules, [], $attributes);

		$validator->validate();

		return $validator->safe();
	}
}
