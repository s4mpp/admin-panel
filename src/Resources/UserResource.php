<?php

namespace S4mpp\AdminPanel\Resources;

use Workbench\App\Models\User;
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

    public function table()
    {
        return [
            Label::text('Nome', 'name')->strong(),
            
            Label::text('E-mail', 'email'),

            Label::dateTime('Cadastrado em', 'created_at'),
        ];
    }

	public function read()
    {
        return [
			Label::text('Nome', 'name')->strong(),
            
            Label::text('E-mail', 'email'),
            
            Label::dateTime('Cadastrado em', 'created_at'),
        ];
    }

    public function form()
    {
        return [
			Input::text('Nome', 'name')->uppercase(),

			Input::email('E-mail', 'email')->uppercase(),
        ];
    }

    public function reports()
    {
        return [
            (new Report('Users registered', [
                Filter::period('Registered at', 'created_at')
            ]))
            ->result('Usuários cadastrados', User::class, 'getUsers')
        ];
    }
}
