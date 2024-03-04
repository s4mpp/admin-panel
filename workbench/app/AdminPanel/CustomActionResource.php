<?php

namespace Workbench\App\AdminPanel;

use S4mpp\AdminPanel\Factories\Input;
use S4mpp\AdminPanel\Factories\Label;
use S4mpp\AdminPanel\Resources\Resource;
use S4mpp\AdminPanel\Factories\CustomAction;

final class CustomActionResource extends Resource
{
    public $title = 'Custom Actions';

    public $actions = ['create', 'update', 'read', 'delete'];

    public function customActions(): array
    {
        return [
            // CALLBACK
            [
                CustomAction::callback('Run callback', function () {
                    return true;
                }),

                CustomAction::callback('Run callback with message', function () {
                    return [ 'result' => 'Resultado ok', 'time' => time(),'name' => 'S4ampp'];
                })->setSuccessMessage(fn($result) => 'Resultado: **'.$result['result'].'** - Tempo: '.$result['time'].' - Nome: '.$result['name']),

                CustomAction::callback('Run callback with error', function () {
                    throw_if(true, 'fail'); return true;
                })->setSuccessMessage('Ok'),
            ],
            // UPDATE
            [
                CustomAction::update('Update', ['title' => rand()]),
                
                CustomAction::update('Update with message', ['title' => 'Title'.rand()])->setSuccessMessage(fn($result) => 'Novo nome: '.$result['title']),
            ],
            // LINK
            [
                CustomAction::link('Open a link', 'https://www.example.com'),
            ],
            // SLIDE
            [
                CustomAction::slide('Slide example', 'slide-example'),
            ],
            // VIEW
            [
                CustomAction::view('View example')->newTab(),
            ]
        ];
    }

    public function table(): array
    {
        return [
            Label::text('Título', 'title'),
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
        ];
    }
}
