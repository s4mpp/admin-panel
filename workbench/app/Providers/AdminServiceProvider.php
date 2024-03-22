<?php

namespace Workbench\App\Providers;

use S4mpp\AdminPanel\AdminPanel;
use S4mpp\AdminPanel\Elements\Card;
use S4mpp\AdminPanel\Factories\Input;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

final class AdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        AdminPanel::createSettings([
            Input::text('Text', 'text')->description('Description of input'),
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
