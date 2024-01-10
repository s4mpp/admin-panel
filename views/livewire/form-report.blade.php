<div x-data="{ {{ join(',', $data_modals)  }} }" x-on:close-modal.window="{{ join(', ', $close_modals ?? []) }}">
	<form @submit.prevent="$dispatch('filter', {filters: filters})" 
		x-data="{loading: false, filters: @entangle('filters')}"
		x-on:submit="loading = true"
		x-on:filter-complete.window="loading = false">
		<div class="mt-3 divide-y divide-gray-300">
			@foreach($fields as $field)
				<div class=" py-3">
					{{ $field->render() }}
				</div>
			@endforeach
		</div>
		<x-button full type="submit" className="mt-4 btn-primary">GERAR RELATÓRIO</x-button>
	</form>

	@foreach($search_fields ?? [] as $search)
		<x-modal title="Selecionar {{ Str::lower($search->getTitle()) }}" idModal="modal{{ $search->getField() }}">
						
			@livewire('select-search', [
				'model' => $search->getModelName(),
				'field_to_search' => 'name',
				'field_to_update' => $search->getField(),
				

				// 'model' => $search->getModel(),
				// 'field_to_search' => $search->getModelField(),
				// 'field_to_update' => $search->getName(),
				// 'repeater' => $search->getRepeater(),
			], key('search-'.$search->getField()))
		</x-modal>
	@endforeach

	@dump($filters)
</div>