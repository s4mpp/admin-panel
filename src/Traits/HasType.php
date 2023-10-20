<?php

namespace S4mpp\AdminPanel\Traits;

trait HasType
{	
	private string $type = 'text';
	
	public function getType(): string
	{
		return $this->type;
	}
}