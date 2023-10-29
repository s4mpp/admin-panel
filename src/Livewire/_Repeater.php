<?php

namespace S4mpp\AdminPanel\Livewire;

use Livewire\Component;
use S4mpp\AdminPanel\Elements\Repeater as ElementsRepeater;

class Repeater extends Component
{
    // public $item = [];

    public $items = [];

    // public $fields  = [];

    public ?int $id_register = null;

    public $title;
    
    public function mount(ElementsRepeater $repeater, $id = null)
    {
        $this->title = $repeater->getTitle();

        $this->id_register = (int)$id;

        $this->items = 

        // $fields = $repeater->getFields();

        // foreach ($fields as $element)
        // {
        //     $this->fields[] = $element;
        // }
    }

    public function render()
    {
        return view('admin::livewire.repeater');
    }

    // public function addItem()
    // {
    //     $this->resetValidation();

    //     try
    //     {
    //         $rules = [
    //             'item.id' => ['nullable', 'numeric', 'min:1'],
    //             'item.name' => ['string', 'required'],
    //         ];

    //         foreach($this->fields as $field)
    //         {
    //             $rules['item.'.$field['name']] = $field['rules'];
    //         }


    //         $validated_input = $this->validate([
    //             'item.id' => ['nullable', 'numeric', 'min:1'],
    //             'item.name' => ['string', 'required'],
    //         ]);
    
    //         $this->items[] = $validated_input['item'];
    
    //         $this->reset('item');
    
    //         $this->dispatchBrowserEvent('reset-loading');
    //     }
    //     catch (\Exception $e)
    //     {
    //         return $this->addError('withdrawal', $e->getMessage());
    //     }
    //     finally
    //     {
    //         $this->dispatchBrowserEvent('reset-loading');
    //     }
    // }
}
