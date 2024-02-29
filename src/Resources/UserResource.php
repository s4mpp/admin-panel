<?php

namespace S4mpp\AdminPanel\Resources;

use Workbench\App\Models\User;
use Illuminate\Validation\Rule;
use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Reports\Report;
use S4mpp\AdminPanel\Factories\Input;
use S4mpp\AdminPanel\Factories\Label;
use S4mpp\AdminPanel\Factories\Filter;
use S4mpp\AdminPanel\Input\Input as InputElement;
use S4mpp\AdminPanel\Labels\Label as LabelElement;

final class UserResource extends Resource
{
    public string $title = 'Usuários';

    /**
     * @var array<string>
     */
    public array $actions = ['create', 'update'];

    // public $search = ['name' => 'Nome', 'email' => 'E-mail'];

    /**
     * @return array<LabelElement|Card>
     */
    public function table(): array
    {
        return [
            Label::text('Nome', 'name')->strong(),

            Label::text('E-mail', 'email')->align('left'),

            Label::dateTime('Cadastrado em', 'created_at'),
        ];
    }

    /**
     * @return array<InputElement|Card>
     */
    public function form(): array
    {
        return [
            Input::text('Nome', 'name')->uppercase(),

            Input::email('E-mail', 'email')->unique()
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
