<div x-data="{ {{ join(',', $data_modals)  }} }" x-on:close-modal.window="{{ join(', ', $close_modals ?? []) }}">
	<form @submit.prevent="$dispatch('filter', {filters: filters}, $dispatch('set-total-filter', {total: total_filters}))" 
		x-data="{filters: @entangle('filters'), total_filters: @entangle('total_filters'), loading: false}"
		x-on:submit="loading = true"
		x-on:filter-complete.window="loading = false, openSlideFilter = false">
		<div class="">
			@foreach($fields as $field)
				@php $i=0; @endphp
				<div class="py-4">
					{{ $field->render() }}
				</div>
			@endforeach
		</div>

		<div class="mt-3 flex justify-between items-center border-t pt-3">
			<button type="button" x-on:click.prevent="$dispatch('reset-filter'), openSlideFilter = false" class="text-red-500 text-sm font-semibold">Limpar</button>
			<x-button type="submit" className="btn-primary">Aplicar</x-button>
		</div>
	</form> 


	@foreach($search_fields ?? [] as $search)
		<x-modal title="Selecionar {{ Str::lower($search->getTitle()) }}" idModal="modal{{ $search->getField() }}">
						
			@livewire('select-search', [
				'model' => \App\Models\Customer::class,
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