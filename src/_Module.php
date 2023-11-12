<?php

namespace S4mpp\AdminPanel;

use Illuminate\Support\Str;

final class Module
{
	private string $slug;

	public function __construct(private string $name, private string $title)
	{
		$this->slug = Str::slug($this->title);
	}

	public function getTitle(): string
	{
		return $this->title;
	}

	public function getSlug(): string
	{
		return $this->slug;
	}

	public function getSection(): ?string
	{
		return null;
	}

	public function getRouteName(string $crud_action): string
	{
		return 'admin.'.$this->name.'.'.$crud_action;
	}

	public function getView(string $view, array $data = [])
	{
		$navigation = AdminPanel::getInstance()->getNavigation(); dump($navigation);
		
		return view('admin::resources.'.$view, array_merge($data, [
			'title' => $this->title,
			'navigation' => $navigation
		]));
	}
}