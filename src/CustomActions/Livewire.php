<?php

namespace S4mpp\AdminPanel\CustomActions;

use Illuminate\Support\Str;

final class Livewire extends CustomAction
{
	public function __construct(private string $title, private string $component)
	{
		parent::__construct($title);
	}

	// public function getComponent(): string
	// {
	// 	return $this->component;
	// }

	public function getNameSlide(): string
	{
		return 'slide'.Str::ucfirst(Str::camel($this->getSlug()));
	}

	public function renderButton()
	{
		return view('admin::custom-actions.buttons.livewire', ['action' => $this]);
	}

	// public function renderContent()
	// {
	// 	return view('admin::custom-actions.content.livewire', ['action' => $this]);
	// }

	// public function renderContentModalConfirmation()
	// {
	// 	return view('admin::custom-actions.modal-confirmation.livewire', ['action' => $this]);
	// }
}