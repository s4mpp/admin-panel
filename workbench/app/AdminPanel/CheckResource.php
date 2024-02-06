<?php

namespace App\AdminPanel;

use App\Models\User;
use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Factories\Input;
use S4mpp\AdminPanel\Factories\Column;
use S4mpp\AdminPanel\Resources\Resource;

class CheckResource extends Resource
{
    public $title = 'Checks';

    // public $actions = ['create'];

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

    // public function form()
    // {
    //     return [
    //         new Card('', [
	// 			Input::select('Usuário', 'user_id', User::all(), 'name'),

	// 			Input::text('Nome', 'name')->unique()->notRequired(),

	// 			Input::date('Hora inicial', 'start_time'),

	// 			Input::date('Hora final', 'end_time'),

	// 			Input::text('E-mail', 'email')->unique(),
    //         ])
    //     ];
    // }
}
