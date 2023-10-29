<?php

namespace S4mpp\AdminPanel\Traits;

trait HasFormAction
{	
	public function renderButton()
	{
		return view('admin::actions.buttons.form', ['action' => $this, 'method' => $this->method_action]);
	}
	
	public function renderContentModalConfirmation()
	{
		return view('admin::actions.modal-confirmation.form', ['action' => $this, 'method' => $this->method_action]);
	}
}