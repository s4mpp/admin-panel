<?php

namespace Workbench\App\AdminPanel;

use S4mpp\AdminPanel\Factories\Input;
use S4mpp\AdminPanel\Factories\Label;
use S4mpp\AdminPanel\Resources\Resource;

final class SelectResource extends Resource
{
    public $title = 'Selects';

    public $actions = ['create', 'update', 'read', 'delete'];

    public function table(): array
    {
        return [
            Label::text('Título', 'title'),
            
            Label::text('Array select', 'array_select'),
            Label::text('Enum select', 'enum_select'),
            Label::text('Collection select', 'collection_select'),
            Label::text('Eloquent collection select', 'eloquent_collection_select'),
            
        ];
    }
    
    public function read(): array
    {
        return [
            Label::text('Título', 'title'),
            
            Label::text('Array select', 'array_select'),
            Label::text('Enum select', 'enum_select'),
            Label::text('Collection select', 'collection_select'),
            Label::text('Eloquent collection select', 'eloquent_collection_select'),
        ];
    }

    public function form(): array
    {
        return [
            Input::text('Título', 'title'),

            Input::select('Array select', 'array_select'),
            Input::select('Enum select', 'enum_select'),
            Input::select('Collection select', 'collection_select'),
            Input::select('Eloquent collection select', 'eloquent_collection_select'),
        ];
    }
}
