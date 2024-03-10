<?php

namespace S4mpp\AdminPanel\Traits;

use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory as ViewFactory;

trait RenderButtonForm
{
    /**
     * @var array<string>
     */
    protected array $component = [
        'button' => 'admin::custom-action.button.form',
        'confirmation' => 'admin::custom-action.confirmation.form'
    ];

    // public function renderButton(): View|ViewFactory
    // {
    //     return view('admin::custom-actions.buttons.form', ['action' => $this]);
    // }
    
    // public function renderContentModalConfirmation(): View|ViewFactory
    // {
    // 	return view('admin::custom-actions.modal-confirmation.form', ['action' => $this]);
    // }






    // public function renderContentModalConfirmation()
    // {
    // 	return view('admin::custom-actions.modal-confirmation.form', ['action' => $this]);
    // }

    // public function renderContentModalConfirmation()
    // {
    // 	return view('admin::custom-actions.modal-confirmation.link', ['action' => $this]);
    // }
}
