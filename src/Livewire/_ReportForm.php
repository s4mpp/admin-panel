<?php

namespace S4mpp\AdminPanel\Livewire;

use Livewire\Component;
use Illuminate\Contracts\View\View;
use S4mpp\AdminPanel\Reports\Report;
use S4mpp\AdminPanel\Resources\Resource;
use S4mpp\AdminPanel\Traits\IsFilterForm;
use S4mpp\AdminPanel\Traits\WithAdminResource;
use S4mpp\AdminPanel\Traits\HasModalSearchInForm;
use Illuminate\Contracts\View\Factory as ViewFactory;

/**
 * @codeCoverageIgnore
 */
final class ReportForm extends Component
{
    use WithAdminResource;
    //  IsFilterForm, HasModalSearchInForm;

    private Report $report;

    public string $report_slug;

    // public $filters;

    // public $report_name;

    // private $search_fields = [];

    // protected $listeners = ['setField'];

    public function mount(Resource $resource, Report $report): void
    {
        $this->resource_slug = $resource->getSlug();

        $this->resource = $resource;

        $this->report_slug = $report->getSlug();
    }

    public function booted(): void
    {
        $this->loadResource();

        $this->report = $this->resource->getReport($this->report_slug);
    }

    public function render(): View|ViewFactory
    {
        return view('admin::livewire.form-report', [
            'fields' => $this->report->getFields(),
            // 'search_fields' => $this->search_fields,
            // 'data_modals' => $this->_getDataModalsAttribute(),
            // 'close_modals' => $this->_getCloseModalsAttribute()
        ]);
    }
}
