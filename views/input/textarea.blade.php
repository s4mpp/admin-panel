
<textarea rows="{{ $input->getRows() }}" class="{{ ($input->getIsUppercase() ? 'uppercase' : null) }}" wire:model.defer="{{ $input->getNameWithPrefix() }}"></textarea>


{{-- <x-input className="{{ ($input->getIsUppercase() ? 'uppercase' : null) }}" type="textarea" title="" :required=$required name="{{ $input->getName() }}" rows="{{ $input->getRows() }}"
	wire:model.defer="{{ $input->getNameWithPrefix() }}">
</x-input> --}}