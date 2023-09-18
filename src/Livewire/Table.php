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
    
    public $filters = [];
    
    private $columns = [];
    
    private Resource $resource;

    private $filters_available = [];

    public function mount(string $resource_name)
    {
        $this->resource_name = $resource_name;
    }

    public function booted()
    {
        $this->resource = Resource::getResource($this->resource_name);

        $this->_setFilters();   
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $collection = $this->resource->getModel()::orderBy($this->resource->ordenation[0] ?? 'id', $this->resource->ordenation[1] ?? 'DESC')
        ->where(function($builder)
        {
            foreach($this->filters as $field => $filter)
            {
                $builder->whereIn($field, array_values($filter['values']));
            }

            if($this->search && is_array($this->resource->search))
            {
                foreach($this->resource->search as $key => $value)
                {
                    $field_to_search = (is_string($key)) ? $key : $value;

                    $builder->orWhere($field_to_search, 'like', '%'.$this->search.'%');
                }
            };
            
        })
        ->paginate();

        return view('admin::livewire.table', [
            'has_search' => $this->resource->search ?? false,
            'registers' => $this->_getData($collection),
            'collection' => $collection,
            'table' => $this->resource->getTable(),
            'actions' => $this->resource->getActions(),
            'routes' => $this->resource->getRoutes(),
            'placeholder_field_search' => $this->_getMessagePlaceholderSearch(),
        ]);
    }

    public function setFilter()
    {
        foreach ($this->filters_available as $filter)
        {
            if(isset($this->filters[$filter->field]))
            {
                $values = array_filter($this->filters[$filter->field]['values']);

                if(!$values)
                {
                    unset($this->filters[$filter->field]);

                    continue;
                }

                $title = $filter->title;

                $values_label = [];

                foreach($values as $value)
                {
                    $option = $this->filters_available[$filter->field]->getOption(intval($value));

                    $values_label[] = $option['label'] ?? '--';
                }

                $title .= ': '.join(', ', $values_label);
                

                $this->filters[$filter->field] = ['title' => $title, 'values' => $values];
            }
        }

        $this->dispatchBrowserEvent('close-slide');
        $this->dispatchBrowserEvent('reset-form');
    }

    public function resetFilter()
    {
        $this->filters = [];

        $this->dispatchBrowserEvent('close-slide');
        $this->dispatchBrowserEvent('reset-form');
    }

    public function removeFilter(string $filter)
    {
        unset($this->filters[$filter]);
    }

    private function _setFilters()
    {
        if(!method_exists($this->resource, 'getFilters'))
        {
            return;
        }

        $filters = $this->resource->getFilters();

        foreach($filters as $filter)
        {
            $this->filters_available[$filter->field] = $filter;
        }
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

    private function _getMessagePlaceholderSearch()
    {
        if(!isset($this->resource->search) || empty($this->resource->search))
        {
            return null;
        }
        
        $fields = [];

        foreach($this->resource->search as $search)
        {
            $fields[] = $search;
        }

        if(count($fields) == 2)
        {
            $label = $fields[0].' ou '.$fields[1];
        }
        elseif(count($fields) >= 3)
        {
            $last_item = array_pop($fields);

            $label = join(', ', $fields).' ou '.$last_item;
        }
        else
        {
            $label = $fields[0];
        }

        return 'Pesquisar por '.$label;
    }
}
