<?php

namespace Workbench\App\AdminPanel;

use S4mpp\AdminPanel\Factories\Input;
use S4mpp\AdminPanel\Factories\Label;
use S4mpp\AdminPanel\Resources\Resource;

final class NumberResource extends Resource
{
    public $title = 'Números';

    public $actions = ['create', 'update', 'read', 'delete'];

    public function table(): array
    {
        return [
            Label::text('Título', 'title'),
          
            Label::text('Basic decimal', 'basic_decimal'),
            Label::text('Basic decimal 2', 'basic_decimal_2'),
            Label::text('Basic decimal min', 'basic_decimal_min'),
            Label::text('Basic decimal max', 'basic_decimal_max'),

            Label::text('Basic integer', 'basic_integer'),
            Label::text('Basic integer 2', 'basic_integer_2'),
            Label::text('Basic integer min', 'basic_integer_min'),
            Label::text('Basic integer max', 'basic_integer_max'),
        ];
    }
    
    public function read(): array
    {
        return [
            Label::text('Título', 'title'),

            Label::text('Basic decimal', 'basic_decimal'),
            Label::text('Basic decimal 2', 'basic_decimal_2'),
            Label::text('Basic decimal min', 'basic_decimal_min'),
            Label::text('Basic decimal max', 'basic_decimal_max'),

            Label::text('Basic integer', 'basic_integer'),
            Label::text('Basic integer 2', 'basic_integer_2'),
            Label::text('Basic integer min', 'basic_integer_min'),
            Label::text('Basic integer max', 'basic_integer_max'),
        ];
    }

    public function form(): array
    {
        return [
            Input::text('Título', 'title'),

            Input::decimal('Basic decimal', 'basic_decimal'),
            Input::decimal('Basic decimal 2', 'basic_decimal_2'),
            Input::decimal('Basic decimal min', 'basic_decimal_min'),
            Input::decimal('Basic decimal max', 'basic_decimal_max'),

            Input::integer('Basic integer', 'basic_integer'),
            Input::integer('Basic integer 2', 'basic_integer_2'),
            Input::integer('Basic integer min', 'basic_integer_min'),
            Input::integer('Basic integer max', 'basic_integer_max'),
        ];
    }
}
