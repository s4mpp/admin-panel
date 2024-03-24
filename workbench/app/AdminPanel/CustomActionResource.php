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
            CustomAction::callback('Run callback', function () {
                return true;
            }),

            CustomAction::callback('Run callback with message', function () {
                return [ 'result' => 'Resultado ok', 'time' => time(),'name' => 'S4ampp'];
            })->setSuccessMessage(fn($result) => 'Resultado: **'.$result['result'].'** - Tempo: '.$result['time'].' - Nome: '.$result['name']),

            CustomAction::callback('Run callback with error', function () {
                throw_if(true, 'fail'); return true;
            })->setSuccessMessage('Ok'),

            CustomAction::callback('Run callback (danger)', function () {
                return true;
            })->danger(),

            CustomAction::callback('Run callback with simple confirm', function () {
                return true;
            })->confirm(),

            CustomAction::callback('Run callback with message confirm', function () {
                return true;
            })->confirm('Confirma?'),

            CustomAction::callback('Run callback with message confirm danger', function () {
                return true;
            })->danger()->confirm('Confirma?'),
            
            // UPDATE
            CustomAction::update('Update item', ['title' => rand()]),
            
            CustomAction::update('Update with message', ['title' => 'Title'.rand()])->setSuccessMessage(fn($result) => 'Novo nome: '.$result['title']),
            
            // LINK
            CustomAction::link('Open a link', 'https://www.example.com'),
            
            CustomAction::link('Open a link (disabled)', 'https://www.example.com')->disabled(fn() => true),
            
            CustomAction::link('Open a link (disabled callback)', 'https://www.example.com')->disabled(true),
            
            CustomAction::link('Open a link (disabled message)', 'https://www.example.com')->disabled(true, 'Campo inativo'),
            
            // SLIDE
            CustomAction::slide('Slide example', 'slide-example'),
            
            CustomAction::slide('Slide danger', 'slide-example')->danger(),
            
            // VIEW
            
            CustomAction::view('View example', 'view-example')->newTab(),
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
