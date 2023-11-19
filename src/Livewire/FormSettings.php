<?php

namespace S4mpp\AdminPanel\Livewire;

use App\Models\Setting;
use Livewire\Component;
use S4mpp\AdminPanel\Settings;
use S4mpp\AdminPanel\Traits\CreatesForm;

class FormSettings extends Component
{
	use CreatesForm;

	private $success_message = 'Configurações salvas com sucesso!';
		
	public function mount($register = null)
	{		
		$this->register = $register;
		
		$this->form = Settings::getForm();
		
		$this->_setInitialData();
	}
	
    public function booted()
    {		
		$this->form = Settings::getForm();
    }

	private function _getModel()
	{
		return Setting::class;
	}

	private function _getRouteForRedirect()
	{
		return 'admin.settings.index';
	}
}
