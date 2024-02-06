<select wire:model.defer="{{ $input->getNameWithPrefix() }}" :required=$required  title="" name="{{ $input->getNameWithPrefix() }}">
	{{-- @foreach($input->getOptions() as $id => $value)
		<x-option value="{{ $id }}">{{ $value }}</x-option>
	@endforeach --}}
</select>