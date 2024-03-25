<?php

namespace S4mpp\AdminPanel\Providers;

use Livewire\Livewire;
use S4mpp\Laraguard\Laraguard;
use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Utils\Finder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use S4mpp\AdminPanel\Livewire\Report;
use Illuminate\Support\ServiceProvider;
use S4mpp\AdminPanel\CustomActions\View;
use S4mpp\AdminPanel\Livewire\FormFilter;
use S4mpp\AdminPanel\Livewire\ReportForm;
use S4mpp\AdminPanel\CustomActions\Update;
use S4mpp\AdminPanel\Livewire\InputSearch;
use S4mpp\AdminPanel\Livewire\ModalSearch;
use S4mpp\AdminPanel\Livewire\FormRepeater;
use S4mpp\AdminPanel\Livewire\FormResource;
use S4mpp\AdminPanel\Livewire\FormSettings;
use S4mpp\AdminPanel\Livewire\ReportResult;
use S4mpp\AdminPanel\CustomActions\Callback;
use S4mpp\AdminPanel\Livewire\TableRepeater;
use S4mpp\AdminPanel\Livewire\TableResource;
use S4mpp\AdminPanel\Livewire\UserPermissions;
use Illuminate\Foundation\Console\AboutCommand;
use S4mpp\AdminPanel\CustomActions\CustomAction;
use S4mpp\AdminPanel\Controllers\ResourceController;
use S4mpp\AdminPanel\Controllers\PermissionController;
use Spatie\Permission\Middleware\PermissionMiddleware;
use S4mpp\AdminPanel\Middleware\CustomAction as CustomActionMiddleware;

/**
 * @codeCoverageIgnore
 */
final class AdminPanelServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $guard_admin = config('admin.guard', 'web');

        $LaraguardPanel = Laraguard::panel('Admin panel', config('admin.prefix', 'painel'), AdminPanel::getGuardName());

        if ($subdomain = config('admin.subdomain', false)) {
            
            /** @var string $subdomain */
            $LaraguardPanel->subdomain($subdomain);
        }

        $LaraguardPanel->layout()
            ->setHtmlFile('admin::html')
            ->setAuthFile('admin::auth')
            ->setLayoutFile('admin::layout');

        $LaraguardPanel->addModule('Dashboard')->starter()->addIndex('admin::dashboard');
        $LaraguardPanel->addModule('Configurações', 'configuracoes')->middleware(PermissionMiddleware::using('Admin.settings', $guard_admin))->hideInMenu()->addIndex('admin::settings');

        $permissions = $LaraguardPanel->addModule('Permissões')->middleware(PermissionMiddleware::using('Admin.permissions', $guard_admin))->hideInMenu()->controller(PermissionController::class)->addIndex();
        $permissions->addPage('', 'generate-permissions', 'generate')->method('put')->action('generatePermissionsAdmin');
        $permissions->addPage('', 'create-permission', 'create-permission')->method('post')->action('createPermission');
        $permissions->addPage('', 'update-permission/{id}', 'update-permission')->method('put')->action('updatePermission');
        $permissions->addPage('', 'delete-permission/{id}', 'delete-permission')->method('delete')->action('deletePermission');
        $permissions->addPage('', 'create-role', 'create-role')->method('post')->action('createRole');
        $permissions->addPage('', 'update-role/{id}', 'update-role')->method('put')->action('updateRole');
        $permissions->addPage('', 'delete-role/{id}', 'delete-role')->method('delete')->action('deleteRole');

        foreach (AdminPanel::loadResources() as $resource) {
                        
            $LaraguardModule = $LaraguardPanel->addModule($resource->getTitle() ?? 'No title', $resource->getSlug() ?? 'no-title')
                ->controller(ResourceController::class);

            $LaraguardModule->hideInMenu(fn() => !Auth::guard($guard_admin)->user()?->can($resource->getName()));

            $LaraguardModule->addPage($resource->getTitle() ?? 'No title', '', 'index')
                ->isIndex()->action('index')
                ->view('admin::resources.index')
                ->middleware(PermissionMiddleware::using($resource->getName(), $guard_admin));

            $LaraguardModule->addPage('Cadastrar', 'cadastrar', 'create')->action('create')->middleware(PermissionMiddleware::using($resource->getName().'.action.create', $guard_admin));
            $LaraguardModule->addPage('Editar', 'editar/{id}', 'update')->action('update')->middleware(PermissionMiddleware::using($resource->getName().'.action.update', $guard_admin));
            $LaraguardModule->addPage('Visualizar', 'visualizar/{id}', 'read')->action('read')->middleware(PermissionMiddleware::using($resource->getName().'.action.read', $guard_admin));
            $LaraguardModule->addPage('Excluir', 'excluir/{id}', 'delete')->action('delete')->method('DELETE')->middleware(PermissionMiddleware::using($resource->getName().'.action.delete', $guard_admin));

            foreach($resource->getReports() as $report)
            {
                $LaraguardModule->addPage('Relatório', 'relatorio/'.$report->getSlug(), $report->getSlug())
                    ->action('report')
                    ->middleware(PermissionMiddleware::using($resource->getName().'.report.'.$report->getSlug(), $guard_admin));
            }


            /** @var array<Callback|Update|View> $custom_actions_with_route */
            $custom_actions_with_route = Finder::onlyOf($resource->getCustomActions(),
                Callback::class,
                Update::class,
                View::class
            );

            foreach ($custom_actions_with_route as $custom_action) {
                $LaraguardModule->addPage($custom_action->getTitle() ?? 'No title', 'acao/'.$custom_action->getSlug().'/{id}', $custom_action->getSlug())
                    ->middleware(CustomActionMiddleware::class, PermissionMiddleware::using($resource->getName().'.custom-action.'.$custom_action->getSlug(), $guard_admin))
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
        Livewire::component('modal-search', ModalSearch::class);
        // Livewire::component('result-report', ReportForm::class);
        // Livewire::component('input-search', InputSearch::class);
        // Livewire::component('form-filter', FormFilter::class);
        Livewire::component('report-result', ReportResult::class);
        Livewire::component('user-permissions', UserPermissions::class);

        Livewire::addPersistentMiddleware([ 
            PermissionMiddleware::class,
        ]);


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
