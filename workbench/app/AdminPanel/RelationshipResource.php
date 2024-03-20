<?php

namespace Workbench\App\AdminPanel;

use Workbench\App\Models\User;
use S4mpp\AdminPanel\Factories\Input;
use S4mpp\AdminPanel\Factories\Label;
use S4mpp\AdminPanel\Resources\Resource;

final class RelationshipResource extends Resource
{
    public $title = 'Relacionamentos';

    public $actions = ['create', 'update', 'read', 'delete'];

    public function table(): array
    {
        return [
            Label::text('Título', 'title'),
            
            Label::text('User', 'user.name'),
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

            Input::select('Usuário', 'user_id')->options(User::get(), 'name')
        ];
    }
}
