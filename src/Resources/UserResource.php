<?php

namespace S4mpp\AdminPanel\Resources;

use S4mpp\AdminPanel\Enums\Action;
use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Elements\Report;
use S4mpp\AdminPanel\Factories\Input;
use S4mpp\AdminPanel\Factories\Label;
use S4mpp\AdminPanel\Factories\Filter;
use S4mpp\AdminPanel\Factories\CustomAction;
use S4mpp\AdminPanel\Input\Input as InputElement;
use S4mpp\AdminPanel\Labels\Label as LabelElement;

final class UserResource extends Resource
{
    public string $title = 'Usuários';

    /**
     * @var array<string>
     */
    public array $actions = ['create', 'read', 'update'];

    /**
     * @var array<string>
     */
    protected $search = ['name' => 'Nome', 'email' => 'E-mail'];

    protected string $ordenation_field = 'name';

    protected string $ordenation_direction = 'ASC';

    public function filters(): array
    {
        return [
            Filter::period('Cadastrado em', 'created_at'),
        ];
    }

    public function customActions(): array
    {
        return [
            CustomAction::slide('Permissões', 'admin::roles-and-permissions.user-permissions'),
        ];
    }

    /**
     * @return array<LabelElement|Card>
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
     * @return array<LabelElement|Card>
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
     * @return array<InputElement|Card>
     */
    public function form(): array
    {
        $form = [
            Input::text('Nome', 'name'),

            Input::email('E-mail', 'email')->unique(),
        ];
 
        
        if($this->getCurrentAction() == Action::Create)
        {
            $form[] = Input::password('Senha', 'password');
        }

        return $form;
    }

    /**
     * @return array<Report>
     */
    public function reports(): array
    {
        return [
            (new Report('Usuários cadastrados', fn ($model, $filter) => $model::where($filter)->select('name', 'email', 'created_at')->paginate(), [
                Label::text('Nome', 'name'),
                Label::text('E-mail', 'email'),
                Label::dateTime('Cadastrado em', 'created_at'),
            ])),
        ];
    }
}
