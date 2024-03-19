<?php

namespace Workbench\App\Enums;

enum OptionsEnum: int
{
	case Option1 = 1;
    case Option2 = 2;

	public function description(): string
    {
        return match($this)
        {
            self::Option1 => 'Option 1',
            self::Option2 => 'Option 2',
        };
    }
}