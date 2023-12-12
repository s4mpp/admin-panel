<?php

namespace S4mpp\AdminPanel\Livewire;

use App\Models\Project;
use Livewire\Component;

class SelectSearch extends Component
{
	public string $field_to_search;
	
	public string $field_to_update;
	
	public ?string $search_term = null;
	
	public $registers = [];
	
	public int $total_registers = 0;
	
	public function mount(string $field_to_search, string $field_to_update)
	{		
		$this->field_to_search = $field_to_search;
		
		$this->field_to_update = $field_to_update;
	}

	public function search()
	{
		if(!$this->search_term)
		{
			$this->reset('registers', 'search_term');

			return;
		}

		$this->registers = Project::where($this->field_to_search, 'like', '%'.$this->search_term.'%')->get();

		$this->total_registers = count($this->registers);
	}

	public function render()
	{
		return view('admin::livewire.select-search');
	}
}
