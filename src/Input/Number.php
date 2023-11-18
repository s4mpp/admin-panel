<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Input\Input;

final class Number extends Input
{
	private const MAX_NUMBER = 99999999999;

	private int | float $step;

	private int | float $min = 0;

	private int | float $max = self::MAX_NUMBER;

	public function renderInput(array $data)
	{
		return view('admin::input.text', ['input' => $this, 'required' => $this->isRequired(), 'data' => $data]);
	}

	public function step(int | float $step)
	{
		$this->step = max($step, 0);

		return $this;
	}

	public function min(int | float $min)
	{
		$this->min = max($min, 0);

		return $this;
	}

	public function max(int | float $max)
	{
		$this->max = min($max, self::MAX_NUMBER);

		return $this;
	}

	public function getStep(): int | float
	{
		return $this->step ?? 1;
	}

	public function getMin(): int | float
	{
		return $this->min;
	}

	public function getMax(): int | float
	{
		return $this->max;
	}
}