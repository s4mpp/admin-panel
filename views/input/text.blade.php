<x-element::form.input className="{{ ($input->getIsUppercase() ? 'uppercase' : null) }}" wire:loading.attr="disabled" wire:model="{{ $input->getNameWithPrefix() }}"  />



{{-- <x-input className="{{ ($input->getIsUppercase() ? 'uppercase' : null) }}" type="text" title="" :required=$required name="{{ $input->getName() }}" x-mask:dynamic="{{ $input->getMask() }}"
	wire:model.defer="{{ $input->getNameWithPrefix() }}">
</x-input> --}}