<?php

namespace Workbench\App\AdminPanel;

use Workbench\App\Models\User;
use S4mpp\AdminPanel\Elements\Card;
use Workbench\App\Enums\OptionsEnum;
use S4mpp\AdminPanel\Factories\Input;
use S4mpp\AdminPanel\Factories\Label;
use S4mpp\AdminPanel\Resources\Resource;

final class CheckboxResource extends Resource
{
    public $title = 'Checkboxes';

    public $actions = ['create', 'update', 'read', 'delete'];

    public function table(): array
    {
        return [
            Label::text('Título', 'title'),

            Label::text('Array', 'array'),
            Label::text('Array multidimensional', 'array_multidimensional'),
            Label::text('Array multidimensional with key', 'array_multidimensional_with_key'),
            Label::text('Array multidimensional with value as key', 'array_multidimensional_with_value_as_key'),
            Label::text('Array with callback', 'array_with_callback'),
            Label::text('Enum', 'enum'),
            Label::text('Enum with callback', 'enum_with_callback'),
            Label::text('Collection', 'collection'),
            Label::text('Collection multidimensional', 'collection_multidimensional'),
            Label::text('Collection multidimensional with key', 'collection_multidimensional_with_key'),
            Label::text('Collection multidimensional with value as key', 'collection_multidimensional_with_value_as_key'),
            Label::text('Eloquent collection', 'eloquent_collection'),
            Label::text('Eloquent collection with key', 'eloquent_collection_with_key'),
            Label::text('Eloquent collection with value as key', 'eloquent_collection_with_value_as_key'),
            
        ];
    }
    
    public function read(): array
    {
        return [
            Label::text('Título', 'title'),

            Label::text('Array', 'array'),
            Label::text('Array multidimensional', 'array_multidimensional'),
            Label::text('Array multidimensional with key', 'array_multidimensional_with_key'),
            Label::text('Array multidimensional with value as key', 'array_multidimensional_with_value_as_key'),
            Label::text('Array with callback', 'array_with_callback'),
            Label::text('Enum', 'enum'),
            Label::text('Enum with callback', 'enum_with_callback'),
            Label::text('Collection', 'collection'),
            Label::text('Collection multidimensional', 'collection_multidimensional'),
            Label::text('Collection multidimensional with key', 'collection_multidimensional_with_key'),
            Label::text('Collection multidimensional with value as key', 'collection_multidimensional_with_value_as_key'),
            Label::text('Eloquent collection', 'eloquent_collection'),
            Label::text('Eloquent collection with key', 'eloquent_collection_with_key'),
            Label::text('Eloquent collection with value as key', 'eloquent_collection_with_value_as_key'),
        ];
    }

    public function form(): array
    {
        $users = User::select('id', 'name', 'email')->limit(5)->get();

        return [
            Input::text('Título', 'title'),

            new Card('Array', [
                Input::checkbox('Array', 'array')->options([1 => 'Sim', 2 => 'Não']),
                Input::checkbox('Array multidimensional', 'array_multidimensional')->options([1 => ['Sim', 'Ok'], 2 => ['Não', 'Not ok']]),
                Input::checkbox('Array multidimensional with key', 'array_multidimensional_with_key')->options([1 => ['Sim', 'Ok'], 2 => ['Não', 'Not ok']], 1),
                Input::checkbox('Array multidimensional with value as key', 'array_multidimensional_with_value_as_key')->options([1 => ['Sim', 'Ok'], 2 => ['Não', 'Not ok']], null, 1),
                Input::checkbox('Array with callback', 'array_with_callback')->options([1 => 'Sim', 2 => 'Não'], callback: fn($value, $key) => $value.' - '. $key),
            ]),

            new Card('Enum', [
                Input::checkbox('Enum', 'enum')->options(OptionsEnum::cases()),
                Input::checkbox('Enum with callback', 'enum_with_callback')->options(OptionsEnum::cases(), callback: fn($value, $key) => $value->description()),
            ]),

            new Card('Collection', [
                Input::checkbox('Collection', 'collection')->options(collect([1 => 'Coleção A', 2 => 'Coleção B'])),
                Input::checkbox('Collection multidimensional', 'collection_multidimensional')->options(collect([1 => ['Coleção A', 'A'], 2 => ['Coleção B', 'b']])),
                Input::checkbox('Collection multidimensional with key', 'collection_multidimensional_with_key')->options(collect([1 => ['Coleção A', 'A'], 2 => ['Coleção B', 'b']]), 0),
                Input::checkbox('Collection multidimensional with value as key', 'collection_multidimensional_with_value_as_key')->options(collect([1 => ['Coleção A', 'A'], 2 => ['Coleção B', 'b']]), 0, 1),
            ]),

            new Card('Eloquent Collection', [
                Input::checkbox('Eloquent collection', 'eloquent_collection')->options($users),
                Input::checkbox('Eloquent collection with key', 'eloquent_collection_with_key')->options($users, 'name'),
                Input::checkbox('Eloquent collection with value as key', 'eloquent_collection_with_value_as_key')->options($users, 'name', 'email'),
            ]),
        ];
    }
}
