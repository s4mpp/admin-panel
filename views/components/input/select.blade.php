<x-element::form.select  wire:model.defer="{{ $input->getNameWithPrefix() }}" {{ $attributes->class(['uppercase' => $input->getIsUppercase()]) }}>
	@foreach($input->getOptions() as $key => $value)
		<option value="{{ $key }}">{{ $key }}: {{ $value }}</option>
	@endforeach
</x-element::form.select>