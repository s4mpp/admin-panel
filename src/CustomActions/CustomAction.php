<?php

namespace S4mpp\AdminPanel\CustomActions;

use Illuminate\Support\Str;
use S4mpp\AdminPanel\Traits\Slugable;
use S4mpp\AdminPanel\Traits\Titleable;

abstract class CustomAction
{
	use Titleable, Slugable;

	private string $success_message = 'Ação concluída com sucesso.';

	// protected $register;

	// DANGEROUS
	//----------------------------------------------------------------
	private ?string $message_confirmation = null;
	
	private bool $has_confirmation = false;
	
	private bool $is_danger = false;
	
	//----------------------------------------------------------------
	
	// DISABLED
	private ?bool $is_disabled = null;
	
	private $disabled_callback;
	
	private ?string $disabled_message = null;
	
	//----------------------------------------------------------------

	// /**
	//  *
	//  * @deprecated
	//  */
	// private array $permissions = [];
	
	// private array $roles = [];

	public function __construct(private string $title)
	{
		$this->createSlug($title);
	}

	public function setSuccessMessage($success_message)
	{
		$this->success_message = $success_message;

		return $this;
	}
	
	public function getSuccessMessage(array $result = null)
	{
		$message =  Str::replaceArray('?', $result, $this->success_message);

		return Str::of($message)->inlineMarkdown();
	}

	// public function setRegister($register)
	// {
	// 	$this->register = $register;

	// 	return $this;
	// }

	// public function getRegister()
	// {
	// 	return $this->register;
	// }

	public function confirm(string $message_confirmation = 'Tem certeza?')
	{
		$this->message_confirmation = $message_confirmation;

		$this->has_confirmation = true;

		return $this;
	}

	public function getMessageConfirmation(): string
	{
		return $this->message_confirmation;
	}

	public function hasConfirmation(): bool
	{
		return $this->has_confirmation;
	}

	// public function getNameModalConfirmation(): string
	// {
	// 	return 'modalConfirmation'.Str::ucfirst(Str::camel($this->getSlug()));
	// }

	// public function renderModalConfirmation()
	// {
	// 	return view('admin::custom-actions.modal-confirmation', ['action' => $this]);
	// }

	// public function renderButtonWithConfirmation()
	// {
	// 	return view('admin::custom-actions.buttons.with-confirmation', ['action' => $this]);
	// }

	public function renderButtonDisabled()
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

	public function danger()
	{
		$this->is_danger = true;

		if(!$this->has_confirmation)
		{
			$this->confirm();
		}

		return $this;
	}

	public function isDangerous(): bool
	{
		return $this->is_danger;
	}

	public function disabled(bool | callable $disabled_callback = true, ?string $disabled_message = null)
	{
		if(is_bool($disabled_callback))
		{
			$this->is_disabled = $disabled_callback;
		}
		else if(is_callable($disabled_callback))
		{
			$this->disabled_callback = $disabled_callback;
		}

		if($disabled_message)
		{
			$this->disabled_message = $disabled_message;
		}

		return $this;
	}

	public function isDisabled(): bool
	{
		if(is_bool($this->is_disabled))
		{		 
			return $this->is_disabled;
		}

		return (is_callable($this->disabled_callback)) ? call_user_func($this->disabled_callback, $this->register) : false;
	}

	public function getDisabledMessage(): ?string
	{
		return $this->disabled_message ?? 'Função não disponível no momento';
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