<?php

namespace S4mpp\AdminPanel\ItemView;

use S4mpp\AdminPanel\Traits\HasLabel;
use S4mpp\AdminPanel\Traits\Titleable;
use Illuminate\Database\Eloquent\Model;
use S4mpp\AdminPanel\Traits\HasDefaultText;

class ItemView
{
	use HasLabel, HasDefaultText, Titleable;
 		
	function __construct(private string $title, private string $field)
	{}

	public function getValue(Model $register)
	{
		$path = explode('.', $this->getField());
                
		$original_data = $register[$path[0]];

		if($original_data)
		{
			array_shift($path);

			foreach($path as $relation)
			{
				$original_data = $original_data[$relation];
			}
		}
		
		return is_callable($this->getCallback()) ? call_user_func($this->getCallback(), $original_data) : $original_data;
	}

	public function render($register = null)
	{
		return view('admin::item-view.item-view', ['item' => $this, 'register' => $register]);
	}

	public function getField(): ?string
	{
		return $this->field;
	}

	public function getView(): ?string
	{
		return $this->view ?? null;
	}
}