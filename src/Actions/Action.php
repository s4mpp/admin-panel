<?php

namespace S4mpp\AdminPanel\Actions;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

abstract class Action
{
	protected $register;
	
	private string $title = '';

	private ?string $message_confirmation = null;

	private bool $has_confirmation = false;

	private bool $is_danger = false;
	
	private ?bool $is_disabled = null;

	private $disabled_callback;

	private ?string $disabled_message = null;

	private array $permissions = [];

	public function setTitle(string $title)
	{
		$this->title = $title;

		return $this;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function getSlug()
	{
		return Str::slug($this->title);
	}

	public function setRegister($register)
	{
		$this->register = $register;

		return $this;
	}

	public function getRegister()
	{
		return $this->register;
	}

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

	public function getNameModalConfirmation(): string
	{
		return 'modalConfirmation'.Str::ucfirst(Str::camel($this->getSlug()));
	}

	public function renderModalConfirmation()
	{
		return view('admin::actions.modal-confirmation', ['action' => $this]);
	}

	public function renderButtonWithConfirmation()
	{
		return view('admin::actions.buttons.with-confirmation', ['action' => $this]);
	}

	public function renderButtonDisabled()
	{
		return view('admin::actions.buttons.disabled', ['action' => $this]);
	}

	public function getTargetWindow(): ?string
	{
		if(method_exists($this, 'isNewTab'))
		{
			return ($this->isNewTab() ? '_blank' : null);
		}

		return null;
	}

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

	public function permissions(array $permissions)
	{
		$this->permissions = $permissions;

		return $this;
	}

	public function getPermissions(): array
	{
		return $this->permissions;
	}

	public function checkPermissions(): bool
	{
		if($this->permissions)
		{
			$guard = config('admin.guard', 'web');

			return Auth::guard($guard)->user()->can($this->permissions);
		}

		return true;
	}
}