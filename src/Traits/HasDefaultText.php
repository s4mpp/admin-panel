<?php

namespace S4mpp\AdminPanel\Traits;

trait HasDefaultText
{	
	private ?string $default_text = null;
	
	public function getDefaultText(): ?string
	{
		return $this->default_text ?? null;
	}

	public function default(string $text)
	{
		$this->default_text = $text;

		return $this;
	}
}