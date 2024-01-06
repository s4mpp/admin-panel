<div x-data="{all: true}" x-on:reset-filter.window="all = true">
	<x-input title="{{ $filter->getTitle() }}" name="{{ $filter->getField() }}[]">
		
		<x-check x-model="all" x-on:change="if(all) filters.{{ $filter->getField() }} = []" value="1">Todos</x-check>
		
		<div x-show="!all" x-cloak>
			<hr>
			@foreach($filter->getOptions() as $id => $value)
				<x-check 
				x-on:change="if(filters.{{ $filter->getField() }}.length == 0) {all = true}"
				x-model="filters.{{ $filter->getField() }}" value="{{ $id }}">{{ $value }}</x-check>
			@endforeach
		</div>
	</x-input>
</div>