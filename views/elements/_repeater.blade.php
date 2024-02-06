<div>
	<x-card title="{{ $repeater->getTitle() }}" :padding=false className="border bg-white">
		<x-slot:header class=" flex justify-end">
			<x-button x-on:click="slide{{ $repeater->getRelation() }} = true; $wire.set('child_id', [])" type="button">Adicionar</x-button>
		</x-slot:header>
		
		<x-table :columns=$columns :registers=$registers />
	</x-card>
</div>