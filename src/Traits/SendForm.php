<?php

namespace S4mpp\AdminPanel\Traits;

trait SendForm
{	
	public function renderButton()
	{
		return view('admin::custom-actions.buttons.form', ['action' => $this, 'method' => $this->method_action]);
	}
	
	public function renderContentModalConfirmation()
	{
		return view('admin::custom-actions.modal-confirmation.form', ['action' => $this, 'method' => $this->method_action]);
	}
}