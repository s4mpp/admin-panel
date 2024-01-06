
<div class="flex justify-start items-center gap-4 rounded-md py-1.5">

	{{-- <input type="text" x-model="filters.{{ $field }}" value="$wire.field"> --}}

	{{-- @if($id = ($data[$input->getName()] ?? null))
		<p class="text-sm text-gray-900">{{ $register->getModel()->{$input->getRelationShip()}()->getRelated()::find($id)->{$input->getModelField()} ?? $id ?? NULL }}</p>
	@else
		<p class="text-sm text-gray-500">(Não selecionado)</p>
	@endif --}}
	
	<button type="button" class=" rounded-lg text-gray-400 hover:text-gray-600 transition-colors" x-on:click="modal{{ $field }} = true">
		<x-icon name="pencil-square" class="h-5"></x-icon>
	</button>

	{{-- @dump($filter) --}}
</div>
