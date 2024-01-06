<?php

namespace S4mpp\AdminPanel\Livewire;

use App\Models\Setting;
use Livewire\Component;
use S4mpp\AdminPanel\Settings;
use Illuminate\Database\Eloquent\Model;
use S4mpp\AdminPanel\Traits\CreatesForm;

class FormSettings extends Component
{
	use CreatesForm;

	protected $listeners = ['setField'];
		
	public function mount($register = null)
	{		
		$this->register = $register;
		
		$this->form = Settings::getForm();
		
		$this->_setInitialData();
	}
	
    public function booted()
    {		
		$this->form = Settings::getForm();

		$this->_setSearchFields();
    }

	private function _getModel()
	{
		return app(Setting::class);
	}

	private function _saving(Model $settings)
	{			
		$settings->save();
		
		session()->flash('message', 'Configurações salvas com sucesso!');

		return redirect()->route('admin.settings.index');
	}

	private function _setSearchFields()
	{
		$this->search_fields = $this->_getSearchFieldsForm();
	}
}
