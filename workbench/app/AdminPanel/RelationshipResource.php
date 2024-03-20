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
            // Label::text('User 2', 'user2.name'),
        ];
    }
    
    public function read(): array
    {
        return [
            Label::text('Título', 'title'),

            Label::text('User', 'user.name'),
            // Label::text('User 2', 'user2.name'),
        ];
    }

    public function form(): array
    {
        return [
            Input::text('Título', 'title'),

            Input::search('Usuário', 'user_id', User::class, 'name'),
            
            Input::search('Usuário 2', 'user_id_2', User::class, 'name'),
        ];
    }
}
