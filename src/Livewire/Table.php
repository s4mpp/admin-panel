<?php

namespace S4mpp\AdminPanel\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use S4mpp\AdminPanel\Filter\Filter;
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
        $collection = $this->_getRegisters();
        
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
                $title = $filter->title;

                switch($filter->getType())
                {
                    case 'enum':

                        $values = array_filter($this->filters[$filter->field]['values']);
        
                        if(!$values)
                        {
                            unset($this->filters[$filter->field]);
        
                            break;
                        }                    
        
                        $values_label = [];
        
                        foreach($values as $value)
                        {
                            $option = $this->filters_available[$filter->field]->getOption(intval($value));
        
                            $values_label[] = $option['label'] ?? '--';
                        }
        
                        $title .= ': '.join(', ', $values_label);
                        
                        $this->filters[$filter->field] = ['type' => 'enum', 'title' => $title, 'values' => $values];
                        
                        break;

                    case 'period';

                        $start = $this->filters[$filter->field]['start'] ?? null;
                        $end = $this->filters[$filter->field]['end'] ?? null;

                        if($start && $end)
                        {
                            $title .= ': '.date('d/m/Y', strtotime($start)).' a '.date('d/m/Y', strtotime($end));
                        }
                        else if($start && !$end)
                        {
                            $title .= ': a partir de '.date('d/m/Y', strtotime($start));
                        }
                        else if($start && !$end)
                        {
                            $title .= ': até '.date('d/m/Y', strtotime($end));
                        }
                        else
                        {
                            break;
                        }
                        
                        $this->filters[$filter->field] = [
                            'type' => 'period',
                            'title' => $title, 
                            'start' => $start,
                            'end' => $end
                        ];
                        
                        break;
                }            

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
        $model = $this->resource->getModel();

        if($model->timestamps)
        {
            $this->filters_available['created_at'] = Filter::create('Período', 'created_at')->period();
        }

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

    private function _getRegisters()
    {
        $table_info = $this->resource->getTable();

        $fields = ['id'];
        $with_eager_loading = [];
        
        foreach($table_info as $column)
        {
            if($column->isRelation())
            {
                $fields[] = $column->field.'_id';

                $with_eager_loading = $column->field.':id,'.$column->fk_field;

                continue;   
            }

            $fields[] = $column->field;
        }

        $query = $this->resource->getModel()->select($fields);
        
        $query = $query->with($with_eager_loading);
        
        $query->orderBy($this->resource->ordenation[0] ?? 'id', $this->resource->ordenation[1] ?? 'DESC');
        
        foreach($this->filters as $field => $filter)
        {
            if($filter['type'] == 'enum')
            {
                $query->whereIn($field, array_values($filter['values']));
            }
            elseif($filter['type'] == 'period')
            {
                $query->where(function($query) use ($field, $filter)
                {
                    if($filter['start'])
                    {
                        $query->where($field, '>=', $filter['start'].' 00:00:00');
                    }

                    if($filter['end'])
                    {
                        $query->where($field, '<=', $filter['end'].' 23:59:59');
                    }
                });
            }
        }
        
        if($this->search && is_array($this->resource->search))
        {
            $query->where(function($builder)
            {
                foreach($this->resource->search as $key => $value)
                {
                    $field_to_search = (is_string($key)) ? $key : $value;

                    $builder->orWhere($field_to_search, 'like', '%'.$this->search.'%');
                }
            });
        } 
        
        return $query->paginate();
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
				$data->data = is_callable($column->getCallback()) ? call_user_func($column->getCallback(), $data->original_data) : $data->original_data;

                
				$data_row[] = $data;
			}
            
            $custom_actions = $this->resource->getCustomActionsResource($row);
			
            $registers[$row->id] = ['registers' => $data_row, 'custom_actions' => $custom_actions];
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
