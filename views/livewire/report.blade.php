<div class="space-y-4" x-on:filter.window="$wire.emit('filterReport', {filters: $event.detail.filters})">
	@if($results)
		@foreach($results as $result)
			<x-card className="border" title="{{ $result['title'] }}" :padding=false>
				@php
					$collection = $result['values'];

					$columns = $result['columns'];
				@endphp
				<x-table :columns=$columns :collection=$collection />
			</x-card>
		@endforeach
	@endif
</div>