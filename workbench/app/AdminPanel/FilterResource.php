<?php

namespace Workbench\App\AdminPanel;

use S4mpp\AdminPanel\Factories\Input;
use S4mpp\AdminPanel\Factories\Label;
use S4mpp\AdminPanel\Factories\Filter;
use S4mpp\AdminPanel\Resources\Resource;

final class FilterResource extends Resource
{
    public $title = 'Filtros';

    public $actions = ['create', 'update', 'read', 'delete'];

    public function filters(): array
    {
        return [
            Filter::period('Cadastrado em', 'created_at')
        ];
    }

    public function table(): array
    {
        return [
            Label::text('Título', 'title'),
        ];
    }
    
    public function read(): array
    {
        return [
            Label::text('Título', 'title'),
        ];
    }

    public function form(): array
    {
        return [
            Input::text('Título', 'title'),
        ];
    }
}
