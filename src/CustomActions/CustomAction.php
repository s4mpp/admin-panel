<?php

namespace S4mpp\AdminPanel\CustomActions;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Contracts\View\View;
use S4mpp\AdminPanel\Traits\Slugable;
use S4mpp\AdminPanel\Traits\Titleable;
use Illuminate\Database\Eloquent\Model;
use S4mpp\AdminPanel\Resources\Resource;
use Illuminate\Contracts\View\Factory as ViewFactory;
use S4mpp\AdminPanel\Traits\HasComponent;

abstract class CustomAction
{
    use Slugable, Titleable, HasComponent;

    

    // protected $register;

    // DANGEROUS
    //----------------------------------------------------------------
    

    //----------------------------------------------------------------

    // DISABLED
    

    //----------------------------------------------------------------

    // /**
    //  *
    //  * @deprecated
    //  */
    // private array $permissions = [];

    // private array $roles = [];

    private Model $register;
    
    private Resource $resource;

    public function __construct(private string $title)
    {
        $this->createSlug($title);
    }

    
    
    
    

    

    

    

    public function renderButtonDisabled(): View|ViewFactory
    {
        return view('admin::custom-actions.buttons.disabled', ['action' => $this]);
    }

    // public function getTargetWindow(): ?string
    // {
    // 	if(method_exists($this, 'isNewTab'))
    // 	{
    // 		return ($this->isNewTab() ? '_blank' : null);
    // 	}

    // 	return null;
    // }

    public function setResource(Resource $resource): void
    {
        $this->resource = $resource;
    }

    public function getResource(): Resource
    {
    	return $this->resource;
    }

    public function setRegister(Model $register): void
    {
    	$this->register = $register;
    }

    public function getRegister(): Model
    {
    	return $this->register;
    }

    

    

    // public function roles(...$roles)
    // {
    // 	$this->roles = $roles;

    // 	return $this;
    // }

    // final public function getRolesForAccess(): array
    // {
    // 	$roles = $this->roles ?? [];

    // 	if(empty($roles) && config('admin.strict_permissions'))
    // 	{
    // 		throw new \Exception('Custom Action "'.$this->getName().'" has no roles (using Strict Permissions)');
    // 	}

    // 	return $roles;
    // }

    // /**
    //  * @deprecated
    //  */
    // public function permissions(...$permissions)
    // {
    // 	$this->permissions = $permissions;

    // 	return $this;
    // }

    // /**
    //  * @deprecated
    //  */
    // public function getPermissionsForAccess(): array
    // {
    // 	$permissions = $this->permissions;

    // 	if(empty($permissions) && config('admin.strict_permissions'))
    // 	{
    // 		throw new \Exception('Custom action "'.$this->getTitle().'" has no permissions (using Strict Permissions)');
    // 	}

    // 	return $permissions;
    // }
}
