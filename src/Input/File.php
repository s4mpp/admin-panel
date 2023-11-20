<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Input\Input;
use Illuminate\Support\Facades\Storage;

final class File extends Input
{
	private $is_public = false;

	private $max_size_mb = 2;

	function __construct(private string $title, private string $name, private string $folder = '')
	{
		parent::__construct($title, $name);
	}

	public function renderInput(array $data)
	{
		$file = $data[$this->getName()] ?? null;

		if($file)
		{
			$is_visible = Storage::exists($file);
	
			$exp = explode('.', $file);
			$type_file = end($exp);
	
			$is_image = in_array(strtolower($type_file), ['png', 'jpg', 'jpeg', 'gif']);
		}

		return view('admin::input.file', [
			'input' => $this,
			'required' => $this->isRequired(),
			'data' => $data,
			'type_file' => $type_file ?? false,
			'is_visible' => $is_visible ?? false,
			'file' => $file,
			'is_image' => $is_image ??false,
		]);
	}

	public function getFolder(): string
	{
		return $this->folder;
	}

	public function public()
	{
		$this->is_public = true;

		return $this;
	}

	public function isPublic(): bool
	{
		return $this->is_public;
	}

	public function max(float $max_size_mb)
	{
		$this->max_size_mb = $max_size_mb = max($max_size_mb, 0.1);

		$max_kb = $max_size_mb * 1024;

		$this->rules('max:'.$max_kb);

		return $this;
	}

	public function getMaxFileSize(): string
	{
		return $this->max_size_mb.' Mb';
	}
}