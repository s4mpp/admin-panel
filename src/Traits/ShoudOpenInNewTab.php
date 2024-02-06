<?php

namespace S4mpp\AdminPanel\Traits;

trait ShoudOpenInNewTab
{
	private bool $new_tab = false;

	public function newTab()
	{
		$this->new_tab = true;

		return $this;
	}

	public function isNewTab(): bool
	{
		return $this->new_tab;
	}

	public function getTargetWindow(): ?string
	{
		return $this->new_tab ? '_blank' : null;
	}
}