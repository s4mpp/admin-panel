<?php

namespace Workbench\App\AdminPanel;

use App\Models\User;
use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Reports\Report;
use S4mpp\AdminPanel\Factories\Input;
use S4mpp\AdminPanel\Factories\Label;
use S4mpp\AdminPanel\Factories\Column;
use S4mpp\AdminPanel\Factories\Filter;
use S4mpp\AdminPanel\Factories\ItemView;
use S4mpp\AdminPanel\Resources\Resource;
use S4mpp\AdminPanel\Factories\CustomAction;

class CustomActionResource extends Resource
{
    public $title = 'Custom Actions';

    public $actions = ['create', 'update', 'read', 'delete'];
    
    // public $search = ['name' => 'Nome', 'email' => 'E-mail'];

    public function customActions()
    {
        return [
            CustomAction::callback('Run callback', function() {
                return [
                    'result' => 'Resultado ok',
                    'time' => time(),
                    'name' => 'Samuel'
                ];
            
            })->setSuccessMessage('Resultado: "?" em ?. Usuário: **?**. Está correto?'),

            CustomAction::link('Open a link', 'https://www.example.com')->disabled(true),
            
            CustomAction::update('Change name', ['name' => rand()]),
            
            CustomAction::livewire('Livewire example', 'livewire-example'),
            
            CustomAction::view('View example'),
        ];
    }

    public function table()
    {
        return [
            Label::text('Título', 'title')->strong(),
            
            Label::longText('Descrição', 'description'),

        ];
    }

	public function read()
    {
        return [
			Label::text('Título', 'title')->strong(),
            
            Label::longText('Descrição', 'description'),            
        ];
    }

    public function form()
    {
        return [
			Input::text('Título', 'title'),

			Input::textarea('Descrição', 'description'),
        ];
    }
}
