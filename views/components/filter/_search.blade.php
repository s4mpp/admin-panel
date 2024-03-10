<div class="flex justify-between items-center ">
	<x-input title="{{ $filter->getTitle() }}">
		@if($id = ($filters[$filter->getField()] ?? null))
			@php
				$description = app($filter->getModelName())->find($id)->{$filter->getFieldToSearch()};
			@endphp
			<p class="text-sm text-gray-900">{{ $description ?? $id ?? NULL }}</p>
		@else
			<p class="text-sm text-gray-500">(Não selecionado)</p>
		@endif
	</x-input>

	<button type="button" class=" rounded-lg text-gray-400 hover:text-gray-600 transition-colors" x-on:click="modal{{ $filter->getField() }} = true">
		<x-icon name="pencil-square" class="h-5"></x-icon>
	</button>
</div>
