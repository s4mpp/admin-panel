<?php

namespace Workbench\App\Providers;

use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Factories\Input;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        AdminPanel::settings([
            Input::text('Text', 'text'),
            Input::textarea('Textarea', 'textarea'),
            Input::decimal('Decimal', 'decimal'),
            Input::integer('integer', 'integer'),
            
            new Card('Card', [
                Input::date('Date', 'date'),
                
                Input::email('E-mail', 'e_mail'),
            ]),
            
            new Card('Inputs multiples', [
                Input::select('Select', 'select'),
                
                Input::checkbox('Check', 'check'),
                
                Input::email('Radio', 'radio'),
            ])
        ]);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
