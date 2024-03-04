<?php

namespace S4mpp\AdminPanel\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Str;
use S4mpp\AdminPanel\Utils;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use S4mpp\AdminPanel\Resource;
use S4mpp\Laraguard\Laraguard;
use Workbench\App\Models\User;
use Illuminate\Validation\Rule;
use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Input\Input;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use S4mpp\AdminPanel\Utils\Finder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Contracts\View\Factory as ViewFactory;

/**
 * @codeCoverageIgnore
 */
final class PermissionController extends Controller
{
    public function __invoke(): ViewFactory|ViewContract|null
    {
        $roles = Role::get();

        $permissions = Permission::get();

        $permissions_admin = new Collection();

        /**
         * @duplicated_code 5
         */
        $permissions_admin = $permissions->filter(function ($permission) {
            return Str::contains($permission->name, 'Admin');
        });
        
        $resources_with_permissions = [
            [
                /**
                 * @duplicated_code 4
                 */
                'name' => 'Admin',
                'permissions' => $permissions_admin->map(function ($permission) {
                    
                    /**
                     * @duplicated_code 1
                     */
                    $total_permission_via_roles = Auth::guard($permission->guard)->getProvider()->getModel()::whereHas('roles.permissions', function ($query) use ($permission) {
                        $query->where('permissions.id', $permission->id);
                    })->count();
                    
                    $total_direct_permissions = $permission->users()->count();

                    $permission->total_users = ($total_direct_permissions + $total_permission_via_roles);

                    return $permission;
                }),
            ]
        ];
        
        foreach (AdminPanel::getResources() as $key => $resource) {

            /**
             * @duplicated_code 5
             */
            $permissions_resource = $permissions->filter(function ($permission) use ($resource) {
                return Str::contains($permission->name, $resource->getName());
            });

            if($permissions_resource->isEmpty())
            {
                continue;
            }

            $resources_with_permissions[] = [
                /**
                 * @duplicated_code 4
                 */
                'name' => $resource->getTitle(),
                'permissions' => $permissions_resource->map(function ($permission) {
                    
                    /**
                     * @duplicated_code 1
                     */
                    $total_permission_via_roles = Auth::guard($permission->guard)->getProvider()->getModel()::whereHas('roles.permissions', function ($query) use ($permission) {
                        $query->where('permissions.id', $permission->id);
                    })->count();
                    
                    $total_direct_permissions = $permission->users()->count();

                    $permission->total_users = ($total_direct_permissions + $total_permission_via_roles);

                    return $permission;
                }),
            ];

            $permissions_admin = $permissions_admin->concat($permissions_resource);
        }

        $other_permissions = Permission::whereNotIn('name', $permissions_admin->pluck('name'))->get();

        /**
         * @duplicated_code 1
         */
        $other_permissions = $other_permissions->map(function ($permission) {
                    
            $total_permission_via_roles = Auth::guard($permission->guard)->getProvider()->getModel()::whereHas('roles.permissions', function ($query) use ($permission) {
                $query->where('permissions.id', $permission->id);
            })->count();
            
            $total_direct_permissions = $permission->users()->count();

            $permission->total_users = ($total_direct_permissions + $total_permission_via_roles);

            return $permission;
        });

        return Laraguard::layout('admin::roles-and-permissions.index', compact('resources_with_permissions', 'other_permissions', 'roles'));
    }

    public function generatePermissionsAdmin()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions_to_create = $this->getPermissionsToCreate();

        $created = $this->createPermissions($permissions_to_create);
        
        $removed = $this->removePermissionsNotUsed($permissions_to_create);

        return back()->withMessage('Permissões atualizadas com sucesso!');
    }

    public function createPermission(Request $request)
    {
        /**
         * @duplicated_code 2
         */
        $request->validate([
            'permission_name' => ['required', 'string', 'max:255', Rule::unique('permissions', 'name')],
        ]);

        $permission = Permission::make(['name' => $request->get('permission_name'), 'guard' => config('admin.guard', 'web')]);

        $permission->name = $request->get('permission_name');

        $permission->saveOrFail();

        return back()->withMessage('Permissão criada com sucesso!');
    }

    public function updatePermission(int $id, Request $request)
    {
        /**
         * @duplicated_code 2
         */
        $request->validate([
            'permission_name' => ['required', 'string', 'max:255', Rule::unique('permissions', 'name')->ignore($id)],
        ]);

        $permission = Permission::findById($id, config('admin.guard', 'web'));

        $permission->name = $request->get('permission_name');

        $permission->saveOrFail();

        return back()->withMessage('Permissão atualizada com sucesso!');
    }

    public function deletePermission(int $id)
    {
        $permission = Permission::findById($id, config('admin.guard', 'web'));

        $permission->delete();

        return back()->withMessage('Permissão removida com sucesso!');
    }

    public function createRole(Request $request)
    {
        /**
         * @duplicated_code 3
         */
        $request->validate([
            'role_name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'permissions' => ['required', 'array', 'min:1'],
        ]);

        $role = Role::make(['name' => $request->get('role_name'), 'guard_name' => config('admin.guard', 'web')]);

        $role->saveOrFail();

        foreach($request->get('permissions') as $permission_name)
        {
            $permission = Permission::findByName($permission_name, config('admin.guard', 'web'));

            $permission?->assignRole($role);
        }

        return back()->withMessage('Grupo criado com sucesso!');
    }
	
	public function updateRole(int $id, Request $request)
    {
        /**
         * @duplicated_code 3
         */
        $request->validate([
            'role_name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($id)],
            'permissions' => ['required', 'array', 'min:1'],
        ]);

        $role = Role::findById($id, config('admin.guard', 'web'));

        $role->name = $request->get('role_name');

        $role->saveOrFail();

        $permissions_to_sync = [];

        foreach($request->get('permissions') as $permission_name)
        {
            $permission = Permission::findByName($permission_name, config('admin.guard', 'web'));

            $permissions_to_sync[] = $permission;
        }

        $role->syncPermissions(array_filter($permissions_to_sync));

        return back()->withMessage('Grupo atualizado com sucesso!');
    }
	
	public function deleteRole(int $id)
    {
        $role = Role::findById($id, config('admin.guard', 'web'));

        $role->delete();

        return back()->withMessage('Grupo removido com sucesso!');
    }

    private function getPermissionsToCreate(): array
    {
        $resources = AdminPanel::getResources();

        $permissions_to_create = [];

        foreach($resources as $resource)
        {
            foreach($resource->getActions() as $action)
            {
                $permissions_to_create[] = $resource->getName().':'.$action;
            }
        }

        return array_merge($permissions_to_create, [
            'Admin:settings', 'Admin:permissions'
        ]);
    }

    private function createPermissions(array $permissions_to_create): array
    {
        foreach($permissions_to_create as $name_permission)
        {
            $permission = Permission::findOrCreate($name_permission, config('admin.guard', 'web'));

            if(!$permission->exists)
            {
                $permissions_created[] = $name_permission;
            }
        }

        return $permissions_created ?? [];
    }

    private function removePermissionsNotUsed(array $permissions_to_create)
    {
        $all_permissions = Permission::where('guard_name', config('admin.guard', 'web'))->get();

        foreach($all_permissions as $permission)
        {
            if(!in_array($permission->name, $permissions_to_create))
            {
                $name = $permission->name;

                $permission->delete();

                $permissions_removed[] = $name;
            }
        }

        return $permissions_removed ?? [];
    }
}
