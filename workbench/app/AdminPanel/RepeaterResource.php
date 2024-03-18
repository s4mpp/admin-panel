<?php

namespace Workbench\App\AdminPanel;

use S4mpp\AdminPanel\Factories\Input;
use S4mpp\AdminPanel\Factories\Label;
use S4mpp\AdminPanel\Elements\Repeater;
use S4mpp\AdminPanel\Resources\Resource;

final class RepeaterResource extends Resource
{
    public $title = 'Repeaters';

    public $actions = ['create', 'update', 'read', 'delete'];

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

    public function repeaters(): array
    {
        return [
            (new Repeater('Child repeaters', 'childRepeaters', [
                Label::text('Título', 'title'),
            ], [
                Input::text('Título', 'title'),
            ]))
            ->orderBy('title', 'ASC'),
            
            new Repeater('Other child repeaters', 'otherChildRepeaters', [
                Label::text('Título', 'title'),
            ])
        ];
    }
}
