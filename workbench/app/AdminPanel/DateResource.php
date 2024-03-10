<?php

namespace Workbench\App\AdminPanel;

use S4mpp\AdminPanel\Factories\Input;
use S4mpp\AdminPanel\Factories\Label;
use S4mpp\AdminPanel\Resources\Resource;

final class DateResource extends Resource
{
    public $title = 'Datas';

    public $actions = ['create', 'update', 'read', 'delete'];

    public function table(): array
    {
        return [
            Label::text('Título', 'title'),
            
            Label::date('Date', 'basic_date'),
            Label::date('Date (no cast)', 'date_no_cast'),

            Label::dateTime('Datetime', 'basic_datetime'),
            Label::dateTime('Datetime (no cast)', 'datetime_no_cast'),
        ];
    }
    
    public function read(): array
    {
        return [
            Label::text('Título', 'title'),

            Label::date('Date', 'basic_date'),
            Label::date('Date (no cast)', 'date_no_cast'),

            Label::dateTime('Datetime', 'basic_datetime'),
            Label::dateTime('Datetime (no cast)', 'datetime_no_cast'),
        ];
    }

    public function form(): array
    {
        return [
            Input::text('Título', 'title'),

            Input::date('Date', 'basic_date')->notRequired(),
            Input::date('Date (no cast)', 'date_no_cast')->notRequired(),

            Input::date('Datetime', 'basic_datetime')->notRequired(),
            Input::date('Datetime (no cast)', 'datetime_no_cast')->notRequired(),
        ];
    }
}
