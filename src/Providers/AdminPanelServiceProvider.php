<?php

namespace S4mpp\AdminPanel\Providers;

use Livewire\Livewire;
use S4mpp\Laraguard\Laraguard;
use S4mpp\AdminPanel\AdminPanel;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use S4mpp\AdminPanel\Components\Table;
use Illuminate\Support\ServiceProvider;
use S4mpp\AdminPanel\Livewire\FormFilter;
use S4mpp\AdminPanel\Livewire\ReportForm;
use S4mpp\AdminPanel\Livewire\InputSearch;
use S4mpp\AdminPanel\Livewire\FormResource;
use S4mpp\AdminPanel\Livewire\FormSettings;
use S4mpp\AdminPanel\Livewire\ReportResult;
use S4mpp\AdminPanel\Livewire\SelectSearch;
use S4mpp\AdminPanel\Livewire\TableRepeater;
use S4mpp\AdminPanel\Livewire\TableResource;
use S4mpp\AdminPanel\Middleware\CustomAction;
use Illuminate\Foundation\Console\AboutCommand;
use S4mpp\AdminPanel\Controllers\ResourceController;

final class AdminPanelServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $admin_panel = Laraguard::panel('Admin panel', 'admin');

        $admin_panel->layout()
            ->setHtmlFile('admin::html')
            ->setAuthFile('admin::auth')
            ->setLayoutFile('admin::layout');

        $admin_panel->addModule('Dashboard')->addIndex();
        $admin_panel->addModule('Settings')->addIndex('admin::settings');

        foreach (AdminPanel::loadResources() as $resource) {
            $module = $admin_panel->addModule($resource->getTitle(), $resource->getSlug())
                ->controller(ResourceController::class)
                ->addIndex('admin::resources.index');

            $module->addPage('Create', 'create')->action('create');
            $module->addPage('Update', 'update/{id}')->action('update');
            $module->addPage('Read', 'read/{id}')->action('read');
            $module->addPage('Delete', 'delete/{id}')->action('delete')->method('DELETE');

            $module->addPage('Report', 'report/{slug}')->action('report');

            foreach ($resource->getCustomActions() as $custom_action) {
                if (! $action = $custom_action->getAction()) {
                    continue;
                }

                $module->addPage($custom_action->getTitle(), $custom_action->getSlug().'/{id}')
                    ->middleware([CustomAction::class])
                    ->method($custom_action->getMethod())
                    ->action($action);
            }
        }
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../views', 'admin');

        // Livewire::component('table-repeater', TableRepeater::class);
        Livewire::component('table-resource', TableResource::class);
        Livewire::component('form-resource', FormResource::class);
        Livewire::component('form-settings', FormSettings::class);
        // Livewire::component('select-search', SelectSearch::class);
        Livewire::component('result-report', ReportForm::class);
        // Livewire::component('input-search', InputSearch::class);
        // Livewire::component('form-filter', FormFilter::class);
        Livewire::component('form-report', ReportResult::class);

        Blade::componentNamespace('S4mpp\\AdminPanel\\Components', 'admin');

        // Paginator::defaultView('admin::pagination');

        if ($this->app->runningInConsole()) {
            AboutCommand::add('Admin Panel', fn () => [
                'Guard' => config('admin.guard', 'web'),
            ]);

            $this->publishes([
                __DIR__.'/../../stubs/config.stub' => config_path('admin.php'),
            ], 'admin-config');

            $this->publishes([
				__DIR__.'/../../style/dist.css' => public_path('vendor/admin-panel/style.css'), 
			], 'admin-assets');
        }
    }
}
