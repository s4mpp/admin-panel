<?php

namespace Workbench\App\AdminPanel;

use S4mpp\AdminPanel\Factories\Input;
use S4mpp\AdminPanel\Factories\Label;
use S4mpp\AdminPanel\Resources\Resource;
use S4mpp\AdminPanel\Factories\CustomAction;

final class CustomActionResource extends Resource
{
    public $title = 'Custom Actions';

    public $actions = ['create', 'update', 'read', 'delete'];

    // public $search = ['name' => 'Nome', 'email' => 'E-mail'];

    public function customActions(): array
    {
        return [
            CustomAction::callback('Run callback', function () {
                return [
                    'result' => 'Resultado ok',
                    'time' => time(),
                    'name' => 'Samuel',
                ];
            })->setSuccessMessage('Resultado: "?" em ?. Usuário: **?**. Está correto?'),

            CustomAction::link('Open a link', 'https://www.example.com')->disabled(true),

            CustomAction::update('Change name', ['name' => rand()]),

            CustomAction::livewire('Livewire example', 'livewire-example'),

            CustomAction::view('View example')->newTab(),
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
