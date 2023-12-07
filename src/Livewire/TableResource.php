<?php

namespace S4mpp\AdminPanel\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use S4mpp\AdminPanel\Column\Actions;
use S4mpp\AdminPanel\Traits\WithAdminResource;

class TableResource extends Component
{
    use WithAdminResource, WithPagination;

    private $collection;
    
    private array $columns = [];
    
    private ?string $search_term = null;
    
    public ?array $filter_term = null;

    protected $listeners = ['searchTable', 'filterTable'];

    public $filter_descriptions = [];

    public function mount(string $resource_name)
	{
		$this->resource_name = $resource_name;
    }

    public function booted()
    {
        $this->_setResource($this->resource_name);

        $this->columns = $this->resource->getTable();

        $actions = [];
        
        foreach($this->resource->getActions() as $action)
        {
            $actions[$action] = $this->resource->getRouteName($action);
        }

        array_push($this->columns, ((new Actions($actions))->align('right')));
    }
    
    public function searchTable(array $params)
    {
        $this->search_term = $params['q'] ?? null;

        $this->dispatchBrowserEvent('search-complete');

        $this->resetPage();
    }

    public function filterTable(array $params)
    {
        $this->reset('filter_descriptions');
        
        $this->filter_term = $params['filters'] ?? null;

        $this->dispatchBrowserEvent('filter-complete');
        
        $this->resetPage();
    }
    
    public function filterRemove()
    {
        $this->reset('filter_descriptions', 'filter_term');
        
        $this->dispatchBrowserEvent('reset-filter');

        $this->resetPage();
    }
    
    public function render()
    {    
        return view('admin::livewire.table-resource', [
            'collection' => $this->_getRegisters(),
            'default_route' => $this->resource->getDefaultRoute(),
            'columns' => $this->columns,
        ]);
    }

    private function _getRegisters()
    {
        $model = $this->resource->getModel();

        $query = $model->orderBy($this->resource->getOrdenationField(), $this->resource->getOrdenationDirection());
                
        $this->_select($query);
        
        $this->_search($query);
        
        $this->_filter($query);
    
        return $query->paginate();
    }

    private function _select($query)
    {
        $select_fields = $this->_getSelectFields(); 

        $with_eager_loading = $this->_getWithEagerLoading($select_fields); 
            
        $query->select(array_unique($select_fields));

        if(!empty($with_eager_loading))
        {
            $query->with(array_map(function($key, $array)
            {
                return $key.':id,'.join(',', $array);
            },
            array_keys($with_eager_loading), $with_eager_loading));
        }
    }

    private function _getSelectFields()
    {
        $select_fields = ['id'];

        foreach(array_filter($this->columns, function($c) { return !$c->isRelation();}) as $column)
		{
            $field = $column->getField();

            if(!$field)
            {
                continue;
            }

            $select_fields[] = $field;
        }

        return $select_fields;
    }

    private function _getWithEagerLoading(&$select_fields)
    {
        foreach(array_filter($this->columns, function($c) { return $c->isRelation();}) as $column)
		{
            $path = explode('.', $column->getField());

            $select_fields[] = $path[0].'_id';
            
            $field = array_pop($path);
            
            $relation_path = join('.', $path);

            if(empty($relation_path))
            {                
                continue;
            }

            $with_eager_loading[$relation_path][] = $field;
                        
            $field_relation = array_pop($path).'_id';

            if(!empty($previous_relation = join('.', $path)))
            {
                $with_eager_loading[$previous_relation][] = $field_relation;
            }
            else
            {
                $select_fields[] = $field_relation;
            }
        }

        return $with_eager_loading ?? [];
    }

    private function _search($query)
    {
        if(!trim($this->search_term))
        {
            return;
        }
        
        $search_fields = $this->resource->getSearchFields();
        
        $query->where(function($builder) use ($search_fields)
        {
            foreach($search_fields as $key => $value)
            {
                $field_to_search = (is_string($key)) ? $key : $value;

                $builder->orWhere($field_to_search, 'like', '%'.trim($this->search_term).'%');
            }
        });
    }

    private function _filter($query)
    {
        if(!$this->filter_term)
        {
            return;
        }
        
        $filters = $this->resource->getFilters();

        foreach($this->filter_term as $f => $term)
        {
            $filter = $filters[$f] ?? null;

            if(!$filter || !$term || empty($term))
            {
                continue;
            } 

            $filter->query($term, $query);  

            $description_result = $filter->getDescriptionResult($term);

            if(!$description_result)
            {
                continue;
            }

            $this->filter_descriptions[] = $filter->getTitle().': '.$description_result;
        }
    }
}
