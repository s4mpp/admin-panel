<div class="overflow-x-auto mb-2" 
	{{-- x-on:reset-filter.window="$wire.set('filter_term', null), $wire.set('filter_descriptions', [])"
	x-on:search.window="$wire.emit('searchTable', {q: $event.detail.q})"
	x-on:filter.window="$wire.emit('filterTable', {filters: $event.detail.filters})" --}}
	>

	<x-admin::table :labels=$columns :collection=$registers />
</div>