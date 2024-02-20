<x-element::form.input type="number" step="{{ $input->getStep() }}" min="{{ $input->getMin() }}" max="{{ $input->getMax() }}"  wire:model.defer="{{ $input->getNameWithPrefix() }}" />



{{-- <x-input type="number" title="" :required=$required name="{{ $input->getName() }}" 
	wire:model.defer="{{ $input->getNameWithPrefix() }}">
</x-input> --}}