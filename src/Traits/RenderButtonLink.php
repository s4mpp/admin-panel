<?php

namespace S4mpp\AdminPanel\Traits;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

trait RenderButtonLink
{
    /**
     * @var array<string>
     */
    protected array $component = [
        'button' => 'admin::custom-action.button.link',
    ];

    // public function renderButton(): View|ViewFactory
    // {
    //     return view('admin::custom-actions.buttons.link', ['action' => $this]);
    // }

    // public function renderContentModalConfirmation()
    // {
    // 	return view('admin::custom-actions.modal-confirmation.link', ['action' => $this]);
    // }
}
