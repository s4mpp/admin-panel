<?php

namespace S4mpp\AdminPanel\Traits;

use Illuminate\Support\Str;

trait Slugable
{	
	private string $slug;

	final public function createSlug(string $text)
	{
		return $this->slug = Str::slug($text);
	}

	final public function getSlug(): ?string
	{
		return $this->slug;
	}
}