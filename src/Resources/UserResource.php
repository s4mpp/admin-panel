<?php

namespace S4mpp\AdminPanel\Resources;

use Workbench\App\Models\User;
use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Reports\Report;
use S4mpp\AdminPanel\Factories\Input;
use S4mpp\AdminPanel\Factories\Label;
use S4mpp\AdminPanel\Factories\Filter;

final class UserResource extends Resource
{
    public string $title = 'Users';

    /**
     * @var array<string>
     */
    public array $actions = ['create', 'update', 'read', 'delete'];

    // public $search = ['name' => 'Nome', 'email' => 'E-mail'];

    /**
     * @return array<Label|Card>
     */
    public function table(): array
    {
        return [
            Label::text('Nome', 'name')->strong(),

            Label::text('E-mail', 'email'),

            Label::dateTime('Cadastrado em', 'created_at'),
        ];
    }

    /**
     * @return array<Label|Card>
     */
    public function read(): array
    {
        return [
            Label::text('Nome', 'name')->strong(),

            Label::text('E-mail', 'email'),

            Label::dateTime('Cadastrado em', 'created_at'),
        ];
    }

    /**
     * @return array<Input|Card>
     */
    public function form(): array
    {
        return [
            Input::text('Nome', 'name')->uppercase(),

            Input::email('E-mail', 'email')->uppercase(),
        ];
    }

    /**
     * @return array<Report>
     */
    public function reports(): array
    {
        return [
            (new Report('Users registered', [
                Filter::period('Registered at', 'created_at'),
            ]))
                ->result('Usuários cadastrados', User::class, 'getUsers'),
        ];
    }
}
