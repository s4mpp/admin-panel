<div x-data="{
	filters: { {{ join(',', $alpine_expression_filters) }} },
	reset() {
		for(filter in this.filters)
		{
			for(field in this.filters[filter])
			{
				this.filters[filter][field] = null;
			}
		}
	}
	}">
	
	<form @submit.prevent="$dispatch('filter', {filters: filters}), loading = true" 
		x-data="{ loading: false}"
		x-on:filter-complete.window="loading = false">
		<div class="">
			@foreach($filters as $filter)
				@php $i=0; @endphp
				<div class="py-4">
					<x-dynamic-component component="{{ $filter->getComponentName() }}" :filter=$filter />
				</div>
			@endforeach
		</div>

		<div class="mt-3 flex justify-between items-center border-t pt-3">
			<x-element::button loading type="submit">Aplicar</x-element::button>
			<button type="button" context="muted" x-on:click="reset(), $dispatch('filter', {filters: filters})">Limpar</button>
		</div>
	</form> 
</div>