<?php

namespace S4mpp\AdminPanel\CustomActions;

use Illuminate\Support\Str;
use Illuminate\Contracts\View\View;
use S4mpp\AdminPanel\Traits\CanBeDisabled;
use S4mpp\AdminPanel\Traits\CanBeDangerous;
use Illuminate\Contracts\View\Factory as ViewFactory;

final class Slide extends CustomAction
{
    use CanBeDisabled, CanBeDangerous;

    /**
     * @var array<string>
     */
    protected array $component = [
        'button' => 'admin::custom-action.button.slide',
        'content' => 'admin::custom-action.content.slide',
        'confirmation' => 'admin::custom-action.confirmation.slide'
    ];

    public function __construct(string $title, private string $view)
    {
        parent::__construct($title);
    }

    public function getView(): string
    {
        return $this->view;
    }

    public function getNameSlide(): string
    {
        return 'slide'.Str::ucfirst(Str::camel($this->getSlug()));
    }

    // public function renderButton(): View|ViewFactory
    // {
    //     return view('admin::custom-actions.buttons.slide', ['action' => $this]);
    // }

    // public function renderContent(): View|ViewFactory
    // {
    // 	return view('admin::custom-actions.content.slide', ['action' => $this]);
    // }

    // public function renderContentModalConfirmation(): View|ViewFactory
    // {
    // 	return view('admin::custom-actions.modal-confirmation.slide', ['action' => $this]);
    // }
}
