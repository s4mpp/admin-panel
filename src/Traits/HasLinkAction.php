<?php

namespace S4mpp\AdminPanel\Traits;

trait HasLinkAction
{	
	public function renderButton()
	{
		return view('admin::actions.buttons.link', ['action' => $this]);
	}

	public function renderContentModalConfirmation()
	{
		return view('admin::actions.modal-confirmation.link', ['action' => $this]);
	}
}