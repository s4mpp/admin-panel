<?php

namespace S4mpp\AdminPanel\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use S4mpp\AdminPanel\Traits\CreatesForm;
use S4mpp\AdminPanel\Traits\ValidateForm;
use S4mpp\AdminPanel\Traits\WithAdminResource;

class FormResource extends Component
{
	use WithAdminResource, WithFileUploads, CreatesForm;

	private $success_message = 'Registro salvo com sucesso!';
		
	public function mount(string $resource_name, $register = null)
	{
		$this->setResource($resource_name);
		
		$this->register = $register;

		$this->repeaters = $this->resource->getRepeaters();
		
		$this->form = $this->resource->getForm();
		
		$this->_setInitialData();
		
		$this->_setInitialChilds();
	}
	
    public function booted()
    {
		$this->setResource($this->resource_name);
		
		$this->form = $this->resource->getForm();

		$this->repeaters = $this->resource->getRepeaters();
    }

	private function _getModel()
	{
		return $this->resource->getModel();
	}

	private function _getRouteForRedirect()
	{
		return $this->resource->getRouteName('index');
	}
}
