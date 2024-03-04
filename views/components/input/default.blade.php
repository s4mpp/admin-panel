<x-element::form.input wire:model.defer="{{ $input->getNameWithPrefix() }}" {{ $attributes->merge($input->getAttributes()) }}  />


{{-- <div class="w-[150px]">
	<x-input type="date" title="" :required=$required name="{{ $input->getName() }}"
		wire:model.defer="{{ $input->getNameWithPrefix() }}">
	</x-input>
</div> --}}