<x-input type="text" title="" :required=$required name="{{ $input->getName() }}" x-mask:dynamic="{{ $input->getMask() }}"
	wire:model.defer="{{ $input->getNameWithPrefix() }}">
</x-input>