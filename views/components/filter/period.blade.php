<div class="flex justify-between">
	<div class="flex-fill">
		<x-element::form.input type="date" x-model="filters.{{ $filter->getField() }}.start" title="Data inicial" />
	</div>
	<span class="text-base text-gray-700 w-12 text-center pb-2 justify-end flex flex-col">até</span>
	<div class="flex-fill">
		<x-element::form.input type="date" x-model="filters.{{ $filter->getField() }}.end" title="Data final" />
	</div>
</div>