<?php

namespace S4mpp\AdminPanel\Traits;

use S4mpp\AdminPanel\Utils;
use Livewire\WithFileUploads;
use S4mpp\AdminPanel\Input\File;
use S4mpp\AdminPanel\Input\Input;
use Livewire\TemporaryUploadedFile;
use Illuminate\Support\ValidatedInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

trait CreatesForm 
{
	use WithFileUploads;
		
	public $register;
	
	public array $data = [];
	
	private $form;

	private $search_fields;

    public function render()
    {
        return view('admin::livewire.form', [
			'model' => $this->resource->getModel(),
			'search_fields' => $this->search_fields ?? [],
			'repeaters' => $this->repeaters ?? [],
			'data_slides' => method_exists($this, '_getDataSlidesAttribute') ? $this->_getDataSlidesAttribute() : null,
			'close_slides' => method_exists($this, '_getCloseSlidesAttribute') ? $this->_getCloseSlidesAttribute() : null,
			'data_modals' => $this->_getDataModalsAttribute(),
			'close_modals' => $this->_getCloseModalsAttribute()
		]);
    }

	private function _setInitialData()
	{
		foreach(Utils::findElement($this->form, Input::class) as $field)
		{
			$this->data[$field->getName()] = $this->_getValueField($field);
		}
	}

	private function _getValueField(Input $field)
	{
		$value = $this->register?->{$field->getName()} ?? null;

		$default_value = (!is_null($field) && is_null($value) ? $field->getDefaultText() : null);

		if($field->getPrepareForForm())
		{
			return $value ? call_user_func($field->getPrepareForForm(), $value) : $default_value;
		}
		
		return $value ?? $default_value;
	}

	public function save()
	{
		$this->resetValidation();

		try
		{
			$fields = Utils::findElement($this->form, Input::class);

			$fields_validated = $this->_validate($this->data, $fields, $this->register?->id);

			$register = $this->_fillData($fields, $fields_validated);
			
			return $this->_saving($register, $fields_validated);
		}
		catch(\Exception $e)
		{
			$this->addError('exception', $e->getMessage());
			
			$this->dispatchBrowserEvent('reset-form');
		}
	}

	private function _fillData(array $fields, ValidatedInput $fields_validated): Model
	{
		$model = $this->_getModel();

		$register = ($this->register) ? $this->register : new $model();

		foreach($fields as $field)
		{
			$data = $fields_validated[$field->getName()] ?? null;

			if(is_a($field, File::class))
			{
				if(!is_a($data, TemporaryUploadedFile::class))
				{
					continue;
				}

				$value = $this->_uploadFile($field, $data);
			}
			else
			{
				$value = $data ?? null;
			}

			$register->{$field->getName()} = $value;
		}

		return $register;
	}

	private function _uploadFile(File $input, $data)
	{
		if($input->isPublic())
		{
			return $data->storePublicly($input->getFolder(), env('FILESYSTEM_DISK', 'public'));
		}
		
		return $data->store($input->getFolder());
	}

	private function _validate($data, array $fields, int $register_id = null)
	{
		$validation_rules = $attributes = [];

		foreach($fields as $field)
		{
			if($field->getPrepareForSave())
			{
				$data[$field->getName()] = call_user_func($field->getPrepareForSave(), $data[$field->getName()]);
			}

			if(is_a($field, File::class) && is_string($data[$field->getName()] ?? null))
			{
				continue;
			}
			
			$validation_rules[$field->getName()] = $field->getRules($this->_getModel()->getTable(), $register_id);
			
			$attributes[$field->getName()] = $field->getTitle();
		}

		$validator = Validator::make($data, $validation_rules, [], $attributes);

		$validator->validate();

		return $validator->safe();
	}

	private function _getDataModalsAttribute(): array
	{
		foreach($this->search_fields ?? [] as $input)
		{
			$data_modals[] = 'modal'.$input->getName().': false';
		}

		return $data_modals ?? [];
	}

	private function _getCloseModalsAttribute(): array
	{
		foreach($this->search_fields ?? [] as $input)
		{
			$close_modals[] = 'modal'.$input->getName().' = false';
		}

		return $close_modals ?? [];
	}

	// private function _getFields(): array
	// {
	// 	return self::_findFields($this->form, []);
	// }

	// private static function _findFields(array $elements, array $fields_found): array
	// {
	// 	foreach($elements as $element)
	// 	{
	// 		if(is_subclass_of($element, Input::class))
	// 		{
	// 			$fields_found[] = $element;
	// 		}
	// 		else
	// 		{
	// 			$fields_found = self::_findFields($element->getElements(), $fields_found);
	// 		}
	// 	}

	// 	return $fields_found;
	// }
}
