<?php

namespace S4mpp\AdminPanel\CustomActions;

use S4mpp\AdminPanel\Traits\CanBeDisabled;
use S4mpp\AdminPanel\Traits\CanBeDangerous;
use S4mpp\AdminPanel\Traits\RenderButtonLink;
use S4mpp\AdminPanel\Traits\ShoudOpenInNewTab;

final class Link extends CustomAction
{
    use RenderButtonLink, ShoudOpenInNewTab, CanBeDisabled, CanBeDangerous;
    

    public function __construct(string $title, private string $url)
    {
        parent::__construct($title);
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}
