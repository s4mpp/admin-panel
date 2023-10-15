<?php

namespace S4mpp\AdminPanel\Livewire;

use Livewire\Component;

class Repeater extends Component
{
    public $item = [];

    public $items = [];

    public function render()
    {
        return view('admin::livewire.repeater');
    }

    public function addItem()
    {
        $this->items[] = $this->item;

        $this->reset('item');

        $this->dispatchBrowserEvent('reset-loading');
    }
}
