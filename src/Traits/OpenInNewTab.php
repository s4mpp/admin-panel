<?php

namespace S4mpp\AdminPanel\Traits;

trait OpenInNewTab
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
}