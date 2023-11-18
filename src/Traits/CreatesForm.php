<?php

namespace S4mpp\AdminPanel\Traits;

use Livewire\WithFileUploads;
use S4mpp\AdminPanel\Input\Input;
use S4mpp\AdminPanel\Traits\ValidateForm;

trait CreatesForm 
{
	use ValidateForm, WithFileUploads;
		
	public $register;
	
	public array $data = [];

	public array $current_child_id = [];
	
	public array $current_child_data = [];
	
	public array $childs = [];
	
	private $repeaters = [];
	
	private $form;

    public function render()
    {
        return view('admin::livewire.form', [
			'repeaters' => $this->repeaters,
			'data_slides' => $this->_getDataSlidesAttribute(),
			'close_slides' => $this->_getCloseSlidesAttribute(),
		]);
    }

	private function _getDataSlidesAttribute(): array
	{
		foreach($this->repeaters ?? [] as $repeater)
		{
			$data_slides[] = 'slide'.$repeater->getRelation().': false';
		}

		return $data_slides ?? [];
		
	}

	private function _getCloseSlidesAttribute(): array
	{
		foreach($this->repeaters ?? [] as $repeater)
		{
			$close_slides[] = 'slide'.$repeater->getRelation().' = false';
		}

		return $close_slides ?? [];
	}

	private function _setInitialData()
	{
		foreach($this->_getFields($this->form) as $field)
		{
			$value = $this->register?->{$field->getName()} ?? null;

			$default_value = (!is_null($field) && is_null($value) ? $field->getDefaultText() : null);

			// if($field->getType() == 'date')
			// {
			// 	$this->data[$field->getName()] = $value ? $value->format('Y-m-d') : $default_value;
			// }
			// else if($field->getType() == 'permissions')
			// {
			// 	$this->data[$field->getName()] = ($value) ? $value->pluck('name') : [];
			// }
			// else if($field->getType() == 'currency')
			// {
			// 	$this->data[$field->getName()] = ($value)  ? Format::currency($value, $field->getAdditionalData('has_cents')) : $default_value;
			// }
			// else
			// {
				$this->data[$field->getName()] = $value ?? $default_value;
			// }
		}
	}

	private function _setInitialChilds()
	{
		foreach($this->repeaters ?? [] as $repeater)
		{
			$this->childs[$repeater->getRelation()] = $this->register ? $this->register->{$repeater->getRelation()} : collect([]);
		}
	}

	public function setCurrentChild(string $relation, int $i)
	{
		$this->current_child_id[$relation] = $i;

		$this->current_child_data[$relation] = $this->childs[$relation][$i];
	}

	public function saveChild(string $relation)
	{
		try
		{
			$repeater = $this->repeaters[$relation]; 

			$data_id = $this->current_child_data[$relation]['id'] ?? null;

			$model = $repeater->getModelRelation();

			if($data_id)
			{
				$register = new $model;

				$register->id = $data_id;
			}
			else
			{
				$register = new $model;
			}

			// $register->project_id = $this->register->id;

			foreach($repeater->getFields() as $field)
			{
				$register->{$field->getName()} = $this->current_child_data[$relation][$field->getName()];
			}

			$child_id_relation = $this->current_child_id[$relation] ?? null;

			if(is_numeric($child_id_relation))
			{
				$this->childs[$relation][$child_id_relation] = $register;
			}
			else
			{
				$this->childs[$relation] = collect($this->childs[$relation])->push($register);
			}
			
			$this->reset('current_child_data', 'current_child_id');
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
			$fields = $this->_getFields($this->form);

			$fields_validated = $this->_validate($this->data, $fields, $this->register?->id);

			$model = $this->_getModel();

			$register = ($this->register) ? $this->register : new $model();

			foreach($fields as $field)
			{
				// if($field->getType() == 'file')
				// {
				// 	$register->{$field->getName()} = $fields_validated[$field->getName()]->storePublicly('documents');
				// }
				// else
				// {
					$register->{$field->getName()} = $fields_validated[$field->getName()] ?? null;
				// }
			}

			// $hook = (!$this->register) ? CreateHook::class : Updatehook::class;
		
			// $hook::before($this->resource, $register, $fields_validated);
			
			$register->save();
			
			// $hook::after($this->resource, $register, $fields_validated);

			$this->_saveChilds($register);

			session()->flash('message', $this->success_message);

			return redirect()->route($this->_getRouteForRedirect());
		}
		catch(\Exception $e)
		{
			$this->addError('exception', $e->getMessage());
			
			$this->dispatchBrowserEvent('reset-form');
		}
	}

	private function _saveChilds($register)
	{
		foreach($this->repeaters ?? [] as $repeater)
		{
			$relation = $repeater->getRelation();

			$model = $repeater->getModelRelation();

			$childs_to_save = [];
			
			foreach($this->childs[$relation] ?? [] as $child)
			{
				$child_to_save = (isset($child['id']) && $child['id']) ? $model::find($child['id']) : new $model();

				foreach($repeater->getFields() as $field)
				{
					$child_to_save->{$field->getName()} = $child[$field->getName()];
				}

				$childs_to_save[] = $child_to_save;
			}

			$register->{$relation}()->saveMany($childs_to_save);
		}
	}

	private function _getFields(): array
	{
		return self::_findFields($this->form, []);
	}

	private static function _findFields(array $elements, array $fields_found): array
	{
		foreach($elements as $element)
		{
			if(is_subclass_of($element, Input::class))
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
}
