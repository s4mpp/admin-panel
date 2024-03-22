<?php

namespace S4mpp\AdminPanel\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\Factory as ViewFactory;

/**
 * @codeCoverageIgnore
 */
final class ModalSearch extends Component
{
    use WithPagination;

    public string $field_to_search;

    // public string $field_to_update;

    public string $model;

    public ?string $search_term = null;

    public int $total_registers = 0;

    public string $field_name;

    // public string $event_set;

    // public ?string $repeater = null;

    /**
     * @return array<string>
     */
    protected function getListeners(): array
    {
        return ['search:'.$this->field_name => 'search'];
    }

    public function mount(string $field_name, string $model, string $field_to_search): void
    {
        $this->fill(compact('field_name', 'model', 'field_to_search'));
    }

    /**
     * @todo Duplicated With TableResource
     *
     * @param  array<string>  $params
     */
    public function search(array $params = []): void
    {
        $this->search_term = $params['q'] ?? null;

        $this->resetPage();

        $this->dispatchBrowserEvent('search-complete');
    }

    public function render(): View|ViewFactory
    {
        return view('admin::livewire.modal-search', [
            'registers' => $this->_getRegisters(),
        ]);
    }

    private function _getRegisters(): ?LengthAwarePaginator
    {
        if (! $this->search_term) {
            return null;
        }

        $collection = $this->model::orderBy($this->field_to_search, 'ASC')
            ->where($this->field_to_search, 'like', '%'.$this->search_term.'%')
            ->paginate(10);

        $this->total_registers = $collection->total();

        return $collection;
    }
}
