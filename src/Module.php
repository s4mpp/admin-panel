<?php

namespace S4mpp\AdminPanel;

use Illuminate\Support\Str;

final class Module
{
	private string $slug;

	public function __construct(private string $title)
	{
		$this->slug = Str::slug($this->title);
	}

	public function getSlug(): string
	{
		return $this->slug;
	}

	public function getRouteName(string $crud_action): string
	{
		return 'admin'.$this->slug.'.'.$crud_action;
	}
}