<?php

namespace S4mpp\AdminPanel\Input;

use S4mpp\AdminPanel\Traits\HasValidationRules;

final class Number extends Input
{
    private const MAX_NUMBER = 99999999999;

    private int|float $step;

    private int|float $min = 0;

    private int|float $max = self::MAX_NUMBER;

    use HasValidationRules;

    // public function render()
    // {
    // 	return view('admin::input.number', ['input' => $this]);
    // }

    public function step(int|float $step): self
    {
        $this->step = max($step, 0);

        return $this;
    }

    public function min(int|float $min): self
    {
        $this->min = max($min, 0);

        return $this;
    }

    public function max(int|float $max): self
    {
        $this->max = min($max, self::MAX_NUMBER);

        return $this;
    }

    public function getStep(): int|float
    {
        return $this->step ?? 1;
    }

    public function getMin(): int|float
    {
        return $this->min;
    }

    public function getMax(): int|float
    {
        return $this->max;
    }

     /**
     * @return array<string|int|float>
     */
    public function getAttributes(): array
    {
        return [
            'type' => 'number',
            'min' => $this->getMin(),
            'max' => $this->getMax(),
            'step' => $this->getStep()
        ];
    }
}
