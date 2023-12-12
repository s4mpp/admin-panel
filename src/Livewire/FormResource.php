<?php

namespace S4mpp\AdminPanel\Livewire;

use Livewire\Component;
use S4mpp\AdminPanel\Utils;
use S4mpp\AdminPanel\Input\Search;
use Illuminate\Support\ValidatedInput;
use S4mpp\AdminPanel\Hooks\CreateHook;
use S4mpp\AdminPanel\Hooks\UpdateHook;
use Illuminate\Database\Eloquent\Model;
use S4mpp\AdminPanel\Traits\CreatesForm;
use S4mpp\AdminPanel\Traits\CanHaveSubForm;
use S4mpp\AdminPanel\Traits\WithAdminResource;

class FormResource extends Component
{
	use WithAdminResource, CreatesForm, CanHaveSubForm;

	private $repeaters = [];

	protected $listeners = ['set'];
		
	public function mount(string $resource_name, $register = null)
	{
		$this->_setResource($resource_name);

		$this->_setRepeaters();

		$this->form = $this->resource->getForm();

		$this->search_fields = Utils::findElement($this->form, Search::class);
				
		$this->register = $register;
		
		$this->_setInitialData();
	}
	
    public function booted()
    {
		$this->_setResource($this->resource_name);

		$this->_setRepeaters();

		$this->form = $this->resource->getForm();

		$this->search_fields = Utils::findElement($this->form, Search::class);
    }
	
	public function set(string $field, $value = null)
	{
		sleep(5);

		if(array_key_exists($field, $this->data))
		{
			$this->data[$field] = $value;		
		}
		
		$this->dispatchBrowserEvent('close-modal');
		$this->dispatchBrowserEvent('reset-loading');
		
		$this->emitSelf('$refresh');
	}

	private function _getModel()
	{
		return $this->resource->getModel();
	}

	private function _saving(Model $register, ValidatedInput $fields_validated)
	{
		$hook = (!$this->register) ? CreateHook::class : Updatehook::class;
	
		$hook::before($this->resource, $register, $fields_validated);
		
		$register->save();
		
		$hook::after($this->resource, $register, $fields_validated);

		$this->_saveChilds($register);

		session()->flash('message', 'Registro salvo com sucesso!');

		return redirect()->route($this->resource->getRouteName('index'));
	}
}
