<?php

namespace S4mpp\AdminPanel\Resources;

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

class UserResource extends Resource
{
    public $title = 'Users';

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
            Label::text('Nome', 'name')->strong(),
            
            Label::text('E-mail', 'email'),

            Label::longText('Nome', 'name'),
            
            Label::markDown('Nome', 'name'),
            
            Label::badge('Nome', 'name'),
            
            Label::boolean('Nome', 'name'),
            
            Label::date('Created at', 'created_at'),
            
            Label::dateTIme('Created at', 'created_at'),
        ];
    }

	public function read()
    {
        return [
			Label::text('Nome', 'name')->strong(),
            
            Label::text('E-mail', 'email'),

            Label::longText('Nome', 'name'),
            
            Label::markDown('Nome', 'name'),
            
            Label::badge('Nome', 'name'),
            
            Label::boolean('Nome', 'name'),
            
            Label::date('Created at', 'created_at'),
            
            Label::dateTime('Created at', 'created_at'),
        ];
    }

    // public function form()
    // {
    //     return [
	// 		Input::text('Nome', 'name')->uppercase(),

	// 		Input::email('E-mail', 'email')->unique()->uppercase(),
    //     ];
    // }

    public function reports()
    {
        return [
            (new Report('Users registered', [
                Filter::period('Registered at', 'created_at')
            ]))
            ->result('Users relation', User::class, 'getUsers')
        ];
    }
}
