<?php

namespace S4mpp\AdminPanel\Traits;

trait HasSuccessMessage
{	
	private string $success_message = 'Ação concluída com sucesso.';

	public function setSuccessMessage($success_message)
	{
		$this->success_message = $success_message;

		return $this;
	}
	
	public function getSuccessMessage()
	{
		return $this->success_message;
	}

}