<?php

namespace S4mpp\AdminPanel\Traits;

trait HasModalSearchInForm 
{
	private $search_fields = [];

	public function bootedHasModalSearchInForm()
	{
		$this->search_fields = $this->_getSearchFieldsForm();
	}

	private function _getDataModalsAttribute(): array
	{
		foreach($this->search_fields ?? [] as $input)
		{
			$data_modals[] = 'modal'.$input->getField().': false';
		}

		return $data_modals ?? [];
	}
	
	private function _getCloseModalsAttribute(): array
	{
		foreach($this->search_fields ?? [] as $input)
		{
			$close_modals[] = 'modal'.$input->getField().' = false';
		}

		return $close_modals ?? [];
	}
}