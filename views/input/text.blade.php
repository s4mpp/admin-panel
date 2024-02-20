<x-element::form.input className="{{ ($input->getIsUppercase() ? 'uppercase' : null) }}" wire:model.defer="{{ $input->getNameWithPrefix() }}" x-mask:dynamic="{{ $input->getMask() }}" />



{{-- <x-input className="{{ ($input->getIsUppercase() ? 'uppercase' : null) }}" type="text" title="" :required=$required name="{{ $input->getName() }}" x-mask:dynamic="{{ $input->getMask() }}"
	wire:model.defer="{{ $input->getNameWithPrefix() }}">
</x-input> --}}