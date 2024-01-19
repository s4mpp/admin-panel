<div class="flex justify-start gap-4 items-center py-2">
	<div>
	@if($id = ($data[$input->getField()] ?? null))
			@php
				$description = app($input->getModelName())->find($id)->{$input->getModelField()};
			@endphp
			<p class="text-sm text-gray-900">{{ $description ?? $id ?? NULL }}</p>
		@else
			<p class="text-sm text-gray-500">(Não selecionado)</p>
		@endif
	</div>

	<button type="button" class=" rounded-lg text-gray-400 hover:text-gray-600 transition-colors" x-on:click="modal{{ $input->getField() }} = true">
		<x-icon name="pencil-square" class="h-5"></x-icon>
	</button>
</div>
