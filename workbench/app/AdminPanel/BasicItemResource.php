<?php

namespace Workbench\App\AdminPanel;

use S4mpp\AdminPanel\Factories\Input;
use S4mpp\AdminPanel\Factories\Label;
use S4mpp\AdminPanel\Resources\Resource;

final class BasicItemResource extends Resource
{
    public $title = 'Itens básicos';

    public $actions = ['create', 'update', 'read', 'delete'];

    public function table(): array
    {
        return [
            Label::text('Título', 'title'),

            Label::text('Texto básico', 'basic_text'),
            
            Label::date('Data', 'basic_date'),
            Label::date('Data (no cast)', 'date_no_cast'),
            
            Label::text('E-mail', 'basic_email'),
            
            Label::longText('Textarea', 'basic_textarea'),
            
            Label::markDown('Markdown', 'long_textarea'),
            
        ];
    }
    
    public function read(): array
    {
        return [
            Label::text('Título', 'title'),

            Label::text('Texto básico', 'basic_text'),
            
            Label::date('Data', 'basic_date'),
            Label::date('Data (no cast)', 'date_no_cast'),
            
            Label::text('E-mail', 'basic_email'),
            
            Label::longText('Textarea', 'basic_textarea'),
            
            Label::markDown('Markdown', 'long_textarea'),
        ];
    }

    public function form(): array
    {
        return [
            Input::text('Título', 'title'),

            Input::text('Texto básico', 'basic_text'),
            
            Input::date('Data', 'basic_date'),
            Input::date('Data (no cast)', 'date_no_cast'),
            
            Input::email('E-mail', 'basic_email'),
            
            Input::textarea('Textarea', 'basic_textarea'),
            Input::textarea('Textarea longa', 'long_textarea', 10),
        ];
    }
}
