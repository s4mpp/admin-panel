<?php

namespace S4mpp\AdminPanel\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use S4mpp\AdminPanel\Labels\Label;
use S4mpp\AdminPanel\Utils\Finder;
use S4mpp\AdminPanel\Elements\Repeater;
use S4mpp\AdminPanel\Traits\WithAdminResource;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @codeCoverageIgnore
 */
final class TableRepeater extends Component
{
    use WithAdminResource, WithPagination;

    private Repeater $repeater;

    public int $main_register_id;

    public string $repeater_slug;

    public function mount(int $main_register_id, string $resource_slug, string $repeater_slug): void
    {
        $this->fill(compact('main_register_id', 'resource_slug', 'repeater_slug'));
    }

    public function booted(): void
    {
        $this->loadResource();

        $this->repeater = Finder::findBySlug($this->resource->repeaters(), $this->repeater_slug);
    }

    public function render() : View|ViewFactory
    {
        return view('admin::livewire.table-repeater', [
            'columns' => Finder::onlyOf($this->repeater->getColumns(), Label::class),
            'registers' => $this->_getRegisters(),
        ]);
    }

    private function _getRegisters(): LengthAwarePaginator
    {
        $relation = $this->repeater->getRelation();

        return $this->resource->getModel()
            ->find($this->main_register_id)->{$relation}()
            ->orderBy($this->repeater->getOrdenationField(), $this->repeater->getOrdenationDirection())
            ->paginate();
    }
}
