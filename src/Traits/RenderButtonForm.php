<?php

namespace S4mpp\AdminPanel\Traits;

trait RenderButtonForm
{
	private string $method = 'GET';

	public function getMethod(): string
	{
		return $this->method;
	}

	public function setMethod(string $method)
	{
		$this->method = $method;

		return $this;
	}

	public function renderButton()
	{
		return view('admin::custom-actions.buttons.form', ['action' => $this]);
	}
	
	public function renderContentModalConfirmation()
	{
		return view('admin::custom-actions.modal-confirmation.form', ['action' => $this]);
	}
}