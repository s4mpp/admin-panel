<?php

namespace S4mpp\AdminPanel\Traits;

trait OpenALink
{	
	public function renderButton()
	{
		return view('admin::custom-actions.buttons.link', ['action' => $this]);
	}

	public function renderContentModalConfirmation()
	{
		return view('admin::custom-actions.modal-confirmation.link', ['action' => $this]);
	}
}