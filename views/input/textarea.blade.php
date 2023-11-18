<x-input type="textarea" title="" :required=$required name="{{ $input->getName() }}" rows="{{ $input->getRows() }}"
	wire:model.defer="{{ $input->getNameWithPrefix() }}">
</x-input>