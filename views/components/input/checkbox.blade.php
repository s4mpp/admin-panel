{{-- <x-input :required=$required  title="" name="{{ $input->getName() }}[]">
	<div class="flex">
		@php
			$i=0;
		@endphp
		@foreach($input->getOptions() as $id => $value)
			<x-check wire:model.defer="{{ $input->getNameWithPrefix() }}" value="{{ $id }}">{{ $value }}</x-check>
			
			@php
				$i++;
			@endphp'
		@endforeach
	</div>
</x-input> --}}
<x-element::form.checkbox>
	@foreach($input->getOptions() as $id => $value)
		<x-element::form.checkbox.item name="{{ $input->getNameWithPrefix() }}" wire:model.defer="{{ $input->getNameWithPrefix() }}" value="{{ $id }}">{{ $value }}</x-check>
	@endforeach
</x-element::form.checkbox>