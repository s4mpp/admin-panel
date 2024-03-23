<?php

namespace S4mpp\AdminPanel\Livewire;

use Closure;
use Livewire\Component;
use Livewire\WithPagination;
use S4mpp\AdminPanel\Labels\Label;
use S4mpp\AdminPanel\Utils\Finder;
use Illuminate\Contracts\View\View;
use S4mpp\AdminPanel\Filter\Filter;
use S4mpp\AdminPanel\Column\Actions;
use S4mpp\AdminPanel\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use S4mpp\AdminPanel\Traits\WithAdminResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory as ViewFactory;

/**
 * @codeCoverageIgnore
 */
final class TableResource extends Component
{
    use Filterable, WithAdminResource, WithPagination;

    /**
     * @var array<string>
     */
    public array $route_actions = [];

    // private $collection;

    // private array $columns = [];

    public ?string $search_term = null;

    /**
     * @var array<string>
     */
    protected $listeners = ['search', 'filter'];

    // protected $listeners = ['searchTable', 'filterTable'];

    // public $filter_descriptions = [];

    /**
     * @var array<string>
     */
    public array $ordenation = [];

    public function mount(string $resource_slug): void
    {
        $this->resource_slug = $resource_slug;

        $this->loadResource();

        $this->route_actions = $this->resource->getRouteActions();

        $this->ordenation = [$this->resource->getOrdenationField() => $this->resource->getOrdenationDirection()];
    }

    public function booted(): void
    {
        $this->loadResource();

        //     $this->columns = $this->resource->getTable();

        //     $actions = [];

        //     foreach($this->resource->getActions() as $action)
        //     {
        //         $actions[$action] = $this->resource->getRouteName($action);
        //     }

        //     array_push($this->columns, ((new Actions($actions))->align('right')));
    }

    /**
     * @todo Duplicated With ModalSearch
     *
     * @param  array<string>  $params
     */
    public function search(array $params): void
    {
        $this->search_term = $params['q'] ?? null;

        $this->resetPage();

        $this->dispatch('search-complete');
    }

    // public function filterRemove()
    // {
    //     $this->reset('filter_descriptions', 'filter_term');

    //     $this->dispatch('reset-filter');

    //     $this->resetPage();
    // }

    public function render(): View|ViewFactory
    {
        return view('admin::livewire.table-resource', [
            // 'collection' => $this->_getRegisters(),
            // 'default_route' => $this->resource->getDefaultRoute(),
            'columns' => Finder::onlyOf($this->resource->table(), Label::class),
            'registers' => $this->_getRegisters(),
        ]);
    }

    private function _getRegisters(): LengthAwarePaginator
    {
        $model = $this->resource->getModel();

        $builder = $model::query();

        foreach ($this->ordenation as $field => $direction) {
            $builder = $model->orderBy($field, $direction);
        }

        $columns = Finder::onlyOf($this->resource->table(), Label::class);

        $select_fields = $this->_getSelectFields(array_filter($columns, fn ($c) => ! $c->isRelationShip()));

        $eager_loading_fields = $this->_getEagerLoadingFields($select_fields, array_filter($columns, fn ($c) => $c->isRelationShip()));

        // dump($select_fields);
        // dd($eager_loading_fields);

        $builder->select(array_unique($select_fields));

        // $builder->with([]);

        $builder->where($this->_search());

        $this->_filter($builder);

        // $this->_search($builder);

        // $this->_filter($builder);

        return $builder->paginate();
    }

    // private function _select($query)
    // {
    //     $select_fields = $this->_getSelectFields();

    //     $query->select(array_unique($select_fields));

    //     // $with_eager_loading = $this->_getWithEagerLoading($select_fields);

    //     // if(!empty($with_eager_loading))
    //     // {
    //     //     $query->with(array_map(function($key, $array)
    //     //     {
    //     //         return $key.':id,'.join(',', $array);
    //     //     },
    //     //     array_keys($with_eager_loading), $with_eager_loading));
    //     // }
    // }

    /**
     * @param  array<Label>  $columns
     * @return array<string>
     */
    private function _getSelectFields(array $columns): array
    {
        $select_fields = ['id'];

        foreach ($columns as $column) {
            $select_fields[] = $column->getField();
        }

        return $select_fields;
    }

    /**
     * @param  array<string>  $select_fields
     * @param  array<Label>  $columns
     * @return array<array<string>>
     */
    private function _getEagerLoadingFields(&$select_fields, array $columns): array
    {
        foreach ($columns as $column) {
            $path = explode('.', $column->getField());

            $select_fields[] = $path[0].'_id';

            $field = array_pop($path);

            $relation_path = implode('.', $path);

            if (empty($relation_path)) {
                continue;
            }

            $with_eager_loading[$relation_path][] = $field;

            $field_relation = array_pop($path).'_id';

            if (! empty($previous_relation = implode('.', $path))) {
                $with_eager_loading[$previous_relation][] = $field_relation;
            } else {
                $select_fields[] = $field_relation;
            }
        }

        return $with_eager_loading ?? [];
    }

    // private function _getWithEagerLoading(&$select_fields)
    // {
    //     foreach(array_filter($this->columns, function($c) { return $c->isRelation();}) as $column)
    // 	{
    //         $path = explode('.', $column->getField());

    //         $select_fields[] = $path[0].'_id';

    //         $field = array_pop($path);

    //         $relation_path = join('.', $path);

    //         if(empty($relation_path))
    //         {
    //             continue;
    //         }

    //         $with_eager_loading[$relation_path][] = $field;

    //         $field_relation = array_pop($path).'_id';

    //         if(!empty($previous_relation = join('.', $path)))
    //         {
    //             $with_eager_loading[$previous_relation][] = $field_relation;
    //         }
    //         else
    //         {
    //             $select_fields[] = $field_relation;
    //         }
    //     }

    //     return $with_eager_loading ?? [];
    // }

    private function _search(): Closure
    {
        return function ($builder): void {
            $search_fields = $this->resource->getSearchFields();

            foreach ($search_fields as $key => $value) {
                $field_to_search = (is_string($key)) ? $key : $value;

                $builder->orWhere($field_to_search, 'like', '%'.trim($this->search_term).'%');
            }
        };
    }

    private function _filter(Builder $builder): void
    {
        if (empty($this->filters)) {
            return;
        }

        $resource_filters = Finder::onlyOf($this->resource->filters(), Filter::class);

        foreach ($resource_filters as $filter) {
            $term = $this->filters[$filter->getField()] ?? null;

            if (is_null($term)) {
                continue;
            }

            $filter->query($builder, $term);
        }

        // foreach($this->filter_term as $filter => $term)
        // {
        //     $filter = $filters[$f] ?? null;

        //     if(!$filter || !$term || empty($term))
        //     {
        //         continue;
        //     }

        //     $filter->query($term, $query);

        //     // /**
        // 	//  * DUPLICATED
        // 	//  */
        //     // if(!$term || empty($term))
        // 	// {
        // 	// 	continue;
        // 	// }

        //     // $description_result = $filter->getDescriptionResult($term);

        //     // if(!$description_result)
        //     // {
        //     //     continue;
        //     // }

        //     // $this->filter_descriptions[] = $filter->getTitle().': '.$description_result;
        // }
    }
}
