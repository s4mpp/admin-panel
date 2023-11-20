<?php

namespace S4mpp\AdminPanel\Traits;

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

    public function render()
    {
        return view('admin::livewire.form', [
			'repeaters' => $this->repeaters ?? [],
			'data_slides' => method_exists($this, '_getDataSlidesAttribute') ? $this->_getDataSlidesAttribute() : null,
			'close_slides' => method_exists($this, '_getCloseSlidesAttribute') ? $this->_getCloseSlidesAttribute() : null,
		]);
    }

	private function _setInitialData()
	{
		foreach($this->_getFields($this->form) as $field)
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
			$fields = $this->_getFields($this->form);

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
			if($field->getPrepareForValidation())
			{
				$data[$field->getName()] = call_user_func($field->getPrepareForValidation(), $data[$field->getName()]);
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
