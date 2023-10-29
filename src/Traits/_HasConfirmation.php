<?php

namespace S4mpp\AdminPanel\Traits;

trait HasConfirmation
{
	private ?string $message_confirmation = null;

	private bool $has_confirmation = false;

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
}