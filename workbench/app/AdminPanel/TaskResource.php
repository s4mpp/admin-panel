<?php

namespace App\AdminPanel;

use App\Models\User;
use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Factories\Input;
use S4mpp\AdminPanel\Factories\Column;
use S4mpp\AdminPanel\Elements\Repeater;
use S4mpp\AdminPanel\Resources\Resource;

class TaskResource extends Resource
{
    public $title = 'Tasks';

    public $actions = ['create'];

    // public $menu_order = 15;

    // public function table()
    // {
    //     return [
    //         Column::text('Usuário', 'user.name'),

    //         Column::text('Nome', 'name'),

    //         Column::datetime('Hora inicial', 'start_time'),

    //         Column::datetime('Fim do tempo', 'end_time'),

    //         Column::text('E-mail', 'email'),
    //     ];
    // }

    public function form()
    {
        return [
            Input::text('Title', 'title'),
        ];
    }

    public function repeaters()
    {
        return [
            (new Repeater('Checks', 'checks'))
            
            
            // , [
            //     Input::text('Título', 'title'),
            // ], [
            //     Column::text('Título', 'title'),
            // ]))
            ->allowAdd()
            ->allowEdit()
        ];
    }
}
