<x-element::form.input type="date"  wire:model.defer="{{ $input->getNameWithPrefix() }}" />


{{-- <div class="w-[150px]">
	<x-input type="date" title="" :required=$required name="{{ $input->getName() }}"
		wire:model.defer="{{ $input->getNameWithPrefix() }}">
	</x-input>
</div> --}}