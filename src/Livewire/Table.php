<?php

namespace S4mpp\AdminPanel\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use S4mpp\AdminPanel\Resources\Resource;

class Table extends Component
{
    use WithPagination;
    
    public string $resource_name;

    public ?string $search = null;

    private $columns = [];
    
    private Resource $resource;

    public function mount(string $resource_name)
    {
        $this->resource_name = $resource_name;
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->resource = Resource::getResource($this->resource_name);

        $collection = $this->resource->model::orderBy($this->resource->ordenation[0] ?? 'id', $this->resource->ordenation[1] ?? 'DESC')
        ->where(function($builder)
        {
            if($this->search)
            {
                foreach($this->resource->search as $field)
                {
                    $builder->orWhere($field, 'like', '%'.$this->search.'%');
                }
            };
        })
        ->paginate();
        
        return view('admin::livewire.table', [
            'registers' => $this->_getData($collection),
            'collection' => $collection,
            'table' => $this->resource->getTable(),
            'actions' => $this->resource->getActions(),
            'routes' => $this->resource->getRoutes(),
        ]);
    }

    private function _getData($collection)
    {
        $registers = [];

        foreach($collection as $row)
		{
			$data_row = [];
			
			foreach($this->resource->getTable() as $column)
			{
				$data = clone $column;

				$data->original_data =  $row->{$column->field};
				$data->data = is_callable($column->callback) ? call_user_func($column->callback, $data->original_data) : $data->original_data;

				$data_row[] = $data;
			}

			$registers[$row->id] = $data_row;
		}

        return $registers;
    }
}
