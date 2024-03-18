<?php

namespace S4mpp\AdminPanel\Providers;

use Livewire\Livewire;
use S4mpp\Laraguard\Laraguard;
use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Utils\Finder;
use Illuminate\Support\Facades\Blade;
use S4mpp\AdminPanel\Livewire\Report;
use Illuminate\Support\ServiceProvider;
use S4mpp\AdminPanel\CustomActions\View;
use S4mpp\AdminPanel\Livewire\FormFilter;
use S4mpp\AdminPanel\Livewire\ReportForm;
use S4mpp\AdminPanel\CustomActions\Update;
use S4mpp\AdminPanel\Livewire\InputSearch;
use S4mpp\AdminPanel\Livewire\FormRepeater;
use S4mpp\AdminPanel\Livewire\FormResource;
use S4mpp\AdminPanel\Livewire\FormSettings;
use S4mpp\AdminPanel\Livewire\ReportResult;
use S4mpp\AdminPanel\Livewire\SelectSearch;
use S4mpp\AdminPanel\CustomActions\Callback;
use S4mpp\AdminPanel\Livewire\TableRepeater;
use S4mpp\AdminPanel\Livewire\TableResource;
use S4mpp\AdminPanel\Livewire\UserPermissions;
use Illuminate\Foundation\Console\AboutCommand;
use S4mpp\AdminPanel\CustomActions\CustomAction;
use S4mpp\AdminPanel\Controllers\ResourceController;
use S4mpp\AdminPanel\Controllers\PermissionController;
use S4mpp\AdminPanel\Middleware\CustomAction as CustomActionMiddleware;

/**
 * @codeCoverageIgnore
 */
final class AdminPanelServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $guard_admin = config('admin.guard', 'web');

        $LaraguardPanel = Laraguard::panel('Admin panel', config('admin.prefix', 'painel'), $guard_admin);

        if ($subdomain = config('admin.subdomain')) {
            $LaraguardPanel->subdomain($subdomain);
        }

        $LaraguardPanel->layout()
            ->setHtmlFile('admin::html')
            ->setAuthFile('admin::auth')
            ->setLayoutFile('admin::layout');

        $LaraguardPanel->addModule('Dashboard')->starter()->addIndex('admin::dashboard');
        $LaraguardPanel->addModule('Configurações', 'configuracoes')->middleware('can:Admin:settings,'.$guard_admin)->hideInMenu()->addIndex('admin::settings');

        $permissions = $LaraguardPanel->addModule('Permissões')->middleware('can:Admin:permissions,'.$guard_admin)->controller(PermissionController::class)->addIndex();
        $permissions->addPage('', 'generate-permissions', 'generate')->method('put')->action('generatePermissionsAdmin');
        $permissions->addPage('', 'create-permission', 'create-permission')->method('post')->action('createPermission');
        $permissions->addPage('', 'update-permission/{id}', 'update-permission')->method('put')->action('updatePermission');
        $permissions->addPage('', 'delete-permission/{id}', 'delete-permission')->method('delete')->action('deletePermission');
        $permissions->addPage('', 'create-role', 'create-role')->method('post')->action('createRole');
        $permissions->addPage('', 'update-role/{id}', 'update-role')->method('put')->action('updateRole');
        $permissions->addPage('', 'delete-role/{id}', 'delete-role')->method('delete')->action('deleteRole');

        foreach (AdminPanel::loadResources() as $resource) {
            $LaraguardModule = $LaraguardPanel->addModule($resource->getTitle() ?? 'No title', $resource->getSlug() ?? 'no-title')
                // ->middleware('can:'.$resource->getName().':module,'.$guard_admin)
                ->controller(ResourceController::class);
            // ->addIndex('admin::resources.index');

            $LaraguardModule->addPage($resource->getTitle(), '', 'index')->isIndex()->action('index')->view('admin::resources.index')->middleware('can:'.$resource->getName().':index,'.$guard_admin);

            $LaraguardModule->addPage('Cadastrar', 'cadastrar', 'create')->action('create')->middleware('can:'.$resource->getName().':create,'.$guard_admin);
            $LaraguardModule->addPage('Editar', 'editar/{id}', 'update')->action('update')->middleware('can:'.$resource->getName().':update,'.$guard_admin);
            $LaraguardModule->addPage('Visualizar', 'visualizar/{id}', 'read')->action('read')->middleware('can:'.$resource->getName().':read,'.$guard_admin);
            $LaraguardModule->addPage('Excluir', 'excluir/{id}', 'delete')->action('delete')->method('DELETE')->middleware('can:'.$resource->getName().':delete,'.$guard_admin);

            $LaraguardModule->addPage('Relatório', 'relatorio/{slug}')->action('report');
            // ->middleware('can:'.$resource->getName().':report,'.$guard_admin);

            $custom_actions_with_route = Finder::onlyOf(Finder::findElementsRecursive($resource->customActions(), CustomAction::class),
                Callback::class,
                Update::class,
                View::class
            );

            foreach ($custom_actions_with_route as $custom_action) {
                $LaraguardModule->addPage($custom_action->getTitle() ?? 'No title', 'acao/'.$custom_action->getSlug().'/{id}', $custom_action->getSlug())
                    ->middleware(CustomActionMiddleware::class)
                    ->method($custom_action->getMethod())
                    ->action($custom_action->getAction());
            }
        }
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../views', 'admin');

        Livewire::component('table-repeater', TableRepeater::class);
        Livewire::component('table-resource', TableResource::class);
        Livewire::component('form-resource', FormResource::class);
        Livewire::component('form-repeater', FormRepeater::class);
        Livewire::component('form-settings', FormSettings::class);
        // Livewire::component('select-search', SelectSearch::class);
        // Livewire::component('result-report', ReportForm::class);
        // Livewire::component('input-search', InputSearch::class);
        // Livewire::component('form-filter', FormFilter::class);
        Livewire::component('report-result', ReportResult::class);
        Livewire::component('user-permissions', UserPermissions::class);

        Blade::componentNamespace('S4mpp\\AdminPanel\\Components', 'admin-panel');

        if ($this->app->runningInConsole()) {
            AboutCommand::add('Admin Panel', fn () => [
                'Guard' => config('admin.guard', 'web'),
            ]);

            $this->publishes([
                __DIR__.'/../../stubs/config.stub' => config_path('admin.php'),
            ], 'admin-config');
        }
    }
}
