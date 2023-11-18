<?php

namespace S4mpp\AdminPanel\Traits;

trait Titleable
{
	public function __toString()
	{
		return $this->getTitle();
	}

	public function getTitle(): string
	{
		return is_null($this->title) ? 'No title' : $this->title;
	}
}