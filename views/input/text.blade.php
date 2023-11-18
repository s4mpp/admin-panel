<x-input type="text" title="" :required=$required name="{{ $input->getName() }}"
	wire:model.defer="{{ $input->getNameWithPrefix() }}">
</x-input>