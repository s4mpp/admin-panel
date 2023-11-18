<x-input title="{{ $filter->getTitle() }}" name="{{ $filter->getField() }}[]">
	@foreach($filter->getOptions() as $id => $value)
		<x-check 
		x-model="filters.{{ $filter->getField() }}" value="{{ $id }}">{{ $value }}</x-check>
	@endforeach
</x-input>