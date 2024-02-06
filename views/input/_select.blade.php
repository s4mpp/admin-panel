<x-input wire:model.defer="{{ $input->getNameWithPrefix() }}" :required=$required type="select" title="" name="{{ $input->getName() }}">
	@foreach($input->getOptions() as $id => $value)
		<x-option value="{{ $id }}">{{ $value }}</x-option>
	@endforeach
</x-input>