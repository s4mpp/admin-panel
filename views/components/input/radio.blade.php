{{-- <x-input :required=$required  title="" name="{{ $input->getName() }}">
	<div class="flex">
		@foreach($input->getOptions() as $id => $value)
			<x-check wire:model.defer="{{ $input->getNameWithPrefix() }}" type="radio" value="{{ $id }}">{{ $value }}</x-check>
		@endforeach
	</div>
</x-input> --}}
<x-element::form.radio>
	@foreach($input->getOptions() as $id => $value)
		<x-element::form.radio.item name="{{ $input->getNameWithPrefix() }}" wire:model.defer="{{ $input->getNameWithPrefix() }}" value="{{ $id }}">{{ $value }}</x-check>
	@endforeach
</x-element::form.radio>