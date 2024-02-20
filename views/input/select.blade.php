<x-element::form.select wire:model.defer="{{ $input->getNameWithPrefix() }}"  title="" name="{{ $input->getNameWithPrefix() }}">
	{{-- @foreach($input->getOptions() as $id => $value)
		<x-option value="{{ $id }}">{{ $value }}</x-option>
	@endforeach --}}
</x-element::form.select>

{{-- :required=$required  --}}