<?php

namespace S4mpp\AdminPanel\Labels;

use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View as View;

final class Actions extends Label
{
    private array $actions = [];

    public function setActions(array $actions)
    {
        $this->actions = $actions;

        return $this;
    }

    public function getActions(): array
    {
        return $this->actions;
    }

    public function showContent(string $content = null): string|View|ViewFactory
    {
        return view('admin::labels.actions', ['value' => $content, 'actions' => $this->getActions()]);
    }
}
