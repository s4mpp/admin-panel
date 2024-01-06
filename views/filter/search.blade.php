{{-- <div>
	<x-input type="text" title="{{ $filter->getTitle() }}" name="{{ $filter->getField() }}" x-model="filters.{{ $filter->getField() }}"></x-input>
</div> --}}

<div>
	@livewire('input-search', [
		'field' => $filter->getField(),
		'title' => $filter->getTitle(),
	])
	
</div>
