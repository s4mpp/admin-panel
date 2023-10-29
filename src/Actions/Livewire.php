<?php

namespace S4mpp\AdminPanel\Actions;

use Illuminate\Support\Str;

final class Livewire extends Action
{
	public function __construct(private string $component)
	{}

	public function getComponent(): string
	{
		return $this->component;
	}

	public function getNameSlide(): string
	{
		return 'slide'.Str::ucfirst(Str::camel($this->getSlug()));
	}

	public function renderButton()
	{
		return view('admin::actions.buttons.livewire', ['action' => $this]);
	}

	public function renderContent()
	{
		return view('admin::actions.content.livewire', ['action' => $this]);
	}

	public function renderContentModalConfirmation()
	{
		return view('admin::actions.modal-confirmation.livewire', ['action' => $this]);
	}
}