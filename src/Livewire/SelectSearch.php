<?php

namespace S4mpp\AdminPanel\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class SelectSearch extends Component
{
	use WithPagination;

	public string $field_to_search;
	
	public string $field_to_update;
	
	public string $model;
		
	public ?string $search_term = null;
	
	private $collection = [];
	
	public int $total_registers = 0;
	
	public function mount(string $model, string $field_to_search, string $field_to_update)
	{		
		$this->field_to_search = $field_to_search;

		$this->field_to_update = $field_to_update;

		$this->model = $model;
	}

	public function search()
	{
		$this->resetPage();
		
		if(!$this->search_term)
		{
			$this->reset('search_term');

			return;
		}

	}

	public function render()
	{
		return view('admin::livewire.select-search', ['collection' => $this->_getRegisters()]);
	}

	private function _getRegisters()
	{
		$collection = $this->model::orderBy($this->field_to_search, 'ASC')->where($this->field_to_search, 'like', '%'.$this->search_term.'%')->paginate();

		$this->total_registers = $collection->total();


		return $collection;
	}
}
