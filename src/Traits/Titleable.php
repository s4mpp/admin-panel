<?php

namespace S4mpp\AdminPanel\Traits;

trait Titleable
{
    public function __toString()
    {
        return $this->getTitle() ?? 'Untitled';
    }

    public function getTitle(): ?string
    {
        return isset($this->title) ? $this->title : null;
    }
}
