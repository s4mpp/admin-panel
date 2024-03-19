<?php

namespace Workbench\App\AdminPanel;

use S4mpp\AdminPanel\Elements\Report;
use S4mpp\AdminPanel\Factories\Input;
use S4mpp\AdminPanel\Factories\Label;
use S4mpp\AdminPanel\Factories\Filter;
use S4mpp\AdminPanel\Resources\Resource;

final class ReportResource extends Resource
{
    public $title = 'Relatórios';

    public $actions = ['create', 'update', 'read', 'delete'];

    public function filters(): array
    {
        return [
            Filter::period('Cadastrado em', 'created_at'),
        ];
    }

    public function table(): array
    {
        return [
            Label::text('Título', 'title'),
            Label::dateTime('Cadastrado em', 'created_at'),
            
        ];
    }
    
    public function read(): array
    {
        return [
            Label::text('Título', 'title'),
            Label::dateTime('Cadastrado em', 'created_at'),
        ];
    }

    public function form(): array
    {
        return [
            Input::text('Título', 'title'),
        ];
    }

    public function reports(): array
    {
        return [
            new Report('Listagem de registros', fn($model, $filter) => $model::where($filter)->paginate(), [
                Label::text('Título', 'title'),
                Label::dateTime('Cadastrado em', 'created_at'),
            ]),

            new Report('Cadastros por data', fn($model, $filter) => $model::reportRegistersByDate($filter), [
                Label::dateTime('Data', 'created_at'),
                Label::text('Total', 'total'),
            ])
        ];
    }
}
