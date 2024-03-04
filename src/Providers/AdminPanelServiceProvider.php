<?php

namespace S4mpp\AdminPanel\Providers;

use Livewire\Livewire;
use S4mpp\Laraguard\Laraguard;
use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Utils\Finder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use S4mpp\AdminPanel\Components\Table;
use S4mpp\AdminPanel\Livewire\Counter;
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
use Illuminate\Foundation\Console\AboutCommand;
use S4mpp\AdminPanel\CustomActions\CustomAction;
use S4mpp\AdminPanel\Controllers\ResourceController;
use S4mpp\AdminPanel\Controllers\PermissionController;
use S4mpp\AdminPanel\CustomActions\Callback;
use S4mpp\AdminPanel\CustomActions\Update;
use S4mpp\AdminPanel\CustomActions\View;
use S4mpp\AdminPanel\Livewire\UserPermissions;
use S4mpp\AdminPanel\Middleware\CustomAction as CustomActionMiddleware;

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
        $LaraguardPanel->addModule('Configurações', 'configuracoes')->hideInMenu()->addIndex('admin::settings');
        
        $permissions = $LaraguardPanel->addModule('Permissões')->controller(PermissionController::class)->addIndex();
        $permissions->addPage('', 'generate-permissions', 'generate')->method('put')->action('generatePermissionsAdmin');
        $permissions->addPage('', 'create-permission', 'create-permission')->method('post')->action('createPermission');
        $permissions->addPage('', 'update-permission/{id}', 'update-permission')->method('put')->action('updatePermission');
        $permissions->addPage('', 'delete-permission/{id}', 'delete-permission')->method('delete')->action('deletePermission');
        $permissions->addPage('', 'create-role', 'create-role')->method('post')->action('createRole');
        $permissions->addPage('', 'update-role/{id}', 'update-role')->method('put')->action('updateRole');
        $permissions->addPage('', 'delete-role/{id}', 'delete-role')->method('delete')->action('deleteRole');

        foreach (AdminPanel::loadResources() as $resource) {
            
            $LaraguardModule = $LaraguardPanel->addModule($resource->getTitle() ?? 'No title', $resource->getSlug() ?? 'no-title')
                ->controller(ResourceController::class)
                ->addIndex('admin::resources.index');

            $LaraguardModule->addPage('Cadastrar', 'cadastrar', 'create')->action('create')->middleware(['can:'.$resource->getName().':create']);
            $LaraguardModule->addPage('Editar', 'editar/{id}', 'update')->action('update')->middleware(['can:'.$resource->getName().':update']);
            $LaraguardModule->addPage('Visualizar', 'visualizar/{id}', 'read')->action('read')->middleware(['can:'.$resource->getName().':read']);
            $LaraguardModule->addPage('Excluir', 'excluir/{id}', 'delete')->action('delete')->method('DELETE')->middleware(['can:'.$resource->getName().':delete']);

            $LaraguardModule->addPage('Relatório', 'relatorio/{slug}')->action('report');

            $custom_actions = Finder::onlyOf(Finder::findElementsRecursive($resource->customActions(), CustomAction::class), 
                Callback::class,
                Update::class,
                View::class
            );

            foreach ($custom_actions as $custom_action) {
                if (! $action = $custom_action->getAction()) {
                    continue;
                }

                $LaraguardModule->addPage($custom_action->getTitle() ?? 'No title', 'acao/'.$custom_action->getSlug().'/{id}', $custom_action->getSlug())
                    ->middleware([CustomActionMiddleware::class])
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
        Livewire::component('user-permissions', UserPermissions::class);
        
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
