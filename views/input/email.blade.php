
	<input type="email" class="{{ ($input->getIsUppercase() ? 'uppercase' : null) }}" wire:model.defer="{{ $input->getNameWithPrefix() }}">


{{-- <x-input className="{{ ($input->getIsUppercase() ? 'uppercase' : null) }}" type="email" title="" :required=$required name="{{ $input->getName() }}"
	wire:model.defer="{{ $input->getNameWithPrefix() }}">
</x-input> --}}