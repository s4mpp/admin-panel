<div class="overflow-x-auto mb-2" 
x-on:reset-filter.window="$wire.set('filter_term', null), $wire.set('filter_descriptions', [])"
x-on:search.window="$wire.emit('searchTable', {q: $event.detail.q})"
x-on:filter.window="$wire.emit('filterTable', {filters: $event.detail.filters})">

	@if($filter_descriptions)
		<div class="min-w-full px-4 sm:px-6 py-2 flex justify-between items-center bg-gray-50 border-t">
			<div>
				<span class="text-sm font-semibold text-gray-600 mr-3">Filtros: </span>

				@foreach($filter_descriptions as $filter)
					<span class="inline-flex items-center gap-x-0.5 rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">
						{{ $filter }}
						{{-- <button wire:click.prevent="removeFilter('{{ $field }}')" type="button" class="group relative -mr-1 h-3.5 w-3.5 rounded-sm hover:bg-yellow-600/20">
							<span class="sr-only">Remove</span>
								<svg viewBox="0 0 14 14" class="h-3.5 w-3.5 stroke-yellow-700/50 group-hover:stroke-yellow-700/75" >
									<path d="M4 4l6 6m0-6l-6 6" />
								</svg>
							<span class="absolute -inset-1"></span>
						</button> --}}
					</span>
				@endforeach
			</div>
 				
			<a href="#" wire:click.prevent="filterRemove" class="text-gray-500">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
					<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
				</svg>
			</a>
		</div>
	@endif


	<x-table :columns=$columns :registers=$collection />
 
	@if($collection->count() > 0)
		@if($collection->hasPages())
			<div class="flex-auto px-3">
				{{ $collection->links('admin::pagination') }}
			</div>
		@endif
		
		<p class="text-center border-t pt-3 text-xs mb-3 text-gray-700">{{ $collection->total() }} {{ Str::plural('registro', $collection->total()) }}</p>
	@endif
</div>