<?php

namespace S4mpp\AdminPanel\Traits;

use S4mpp\AdminPanel\Utils;
use S4mpp\AdminPanel\Filter\Search;

trait IsFilterForm 
{
	// public function bootedIsFilterForm()
    // {
	// 	if(!isset($this->filters))
	// 	{
	// 		$this->_resetFilter();
	// 	}
	// }

	// public function resetFilter()
	// {
	// 	$this->_resetFilter();

	// 	$this->dispatchBrowserEvent('reset-filter');
	// }

	// public function setField(string $relation = null, string $field, $value = null)
	// {
	// 	$this->filters[$field] = $value;
		
	// 	$this->dispatchBrowserEvent('close-modal');
	// 	$this->dispatchBrowserEvent('reset-loading');
		
	// 	$this->emitSelf('$refresh');
	// }

	// private function _resetFilter()
	// {
	// 	foreach($this->resource->getFilters() ?? [] as $input)
	// 	{
	// 		$this->filters[$input->getField()] = method_exists($input, 'getInitialValue') ? $input->getInitialValue() : null;
	// 	}
	// }
	
	// private function _getSearchFieldsForm(): array
	// {
	// 	return Utils::findElement($this->resource->getFilters(), Search::class);
	// }
}