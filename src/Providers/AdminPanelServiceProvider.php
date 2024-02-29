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
use S4mpp\AdminPanel\Livewire\Counter;

/**
 * @codeCoverageIgnore
 */
final class AdminPanelServiceProvider extends ServiceProvider
{
    public function register(): void
    {
 
        $LaraguardPanel = Laraguard::panel('Admin panel', 'admin');

        $LaraguardPanel->layout()
            ->setHtmlFile('admin::html')
            ->setAuthFile('admin::auth')
            ->setLayoutFile('admin::layout');

        $LaraguardPanel->addModule('Dashboard')->starter()->addIndex();
        $LaraguardPanel->addModule('Settings')->hideInMenu()->addIndex('admin::settings');

        foreach (AdminPanel::loadResources() as $resource) {
            
            $LaraguardModule = $LaraguardPanel->addModule($resource->getTitle() ?? 'No title', $resource->getSlug() ?? 'no-title')
                ->controller(ResourceController::class)
                ->addIndex('admin::resources.index');

            $LaraguardModule->addPage('Cadastrar', 'cadastrar', 'create')->action('create');
            $LaraguardModule->addPage('Editar', 'editar/{id}', 'update')->action('update');
            $LaraguardModule->addPage('Visualizar', 'visualizar/{id}', 'read')->action('read');
            $LaraguardModule->addPage('Excluir', 'excluir/{id}', 'delete')->action('delete')->method('DELETE');

            $LaraguardModule->addPage('Relatório', 'relatorio/{slug}')->action('report');

            foreach ($resource->getCustomActions() as $custom_action) {
                if (! $action = $custom_action->getAction()) {
                    continue;
                }

                $LaraguardModule->addPage($custom_action->getTitle() ?? 'No title', $custom_action->getSlug().'/{id}')
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
                __DIR__.'/../../assets/css/style.min.css' => public_path('vendor/admin-panel/style.min.css'),
                __DIR__.'/../../assets/js/script.min.js' => public_path('vendor/admin-panel/script.min.js'),
            ], 'admin-assets');
        }
    }
}
