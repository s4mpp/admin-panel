@extends('admin::layout', ['breadcrumbs' => []])

@section('title', $title)

@section('title-page')
	@if($resource->hasAction('create'))
		<x-link href="{{ route($resource->getRouteName('create')) }}" className="btn-primary">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
				<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" />
			</svg>

			<span>Cadastrar</span>
		</x-link>
	@endif
@endsection

@section('content')

	<x-alert/>

	@if($table = $resource->getTable())

		<x-card className="bg-white border" :padding=false>
			<div class="min-w-full px-2  py-2 flex justify-start">

				@if($placeholder_search = $resource->getMessagePlaceholderSearch())
					<div class="w-full sm:w-6/12 md:w-5/12 xl:w-4/12 mr-3" x-data="{searching: false}" x-on:search-complete.window="searching = false">
						<x-input placeholder="Pesquisar por {{ $placeholder_search }}" type="search" x-on:keyup.debounce="$dispatch('search', {q: $event.target.value}), searching = true">
							<x-slot:start>
								<div x-show="searching" x-cloak>
									<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class=" animate-spin w-5 h-5">
										<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
									</svg>
								</div>
								<div x-show="!searching" x-cloak>
									<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
										<path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
									</svg>
								</div>
							</x-slot:start>
						</x-input>
					</div>
				@endif

				@if($filters = $resource->getFilters())
					<div class="relative inline-block text-left" x-data="{openSlideFilter: false, total_filters: 0}" x-on:reset-filter.window="total_filters = 0">
						<x-button type="button" className="btn-light" x-on:click="openSlideFilter = true">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
								<path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
							</svg>
							
							<span x-show="total_filters > 0" class="absolute justify-center flex items-center right-0 top-0 h-4 w-4 -translate-y-1/2 translate-x-1/2 transform rounded-full bg-orange-300 ring-2 ring-white">
								<span class="text-[12px] text-white" x-text="total_filters"></span>
							</span>
							
						</x-button>

						@php
							$alpine_data_filters = [];

							foreach($filters as $filter)
							{
								$alpine_data_filters[] = $filter->getField().': '.$filter->getAlpineExpression();
							}
						@endphp

						<x-slide-over id="openSlideFilter" title="Filtros">
							<form @submit.prevent="$dispatch('filter', {filters: filters}), total_filters = countFilters()" 
							x-data="{
								init()
								{
									this.total = 0,
									this.loading = false,
									this.filters = { {{ join(',', $alpine_data_filters) }} }
								},
								countFilters()
								{
									let total = 0;

									for(filter in this.filters)
									{
										let field = this.filters[filter];

										if(typeof field == 'object')
										{
											if(Object.values(field).filter((el) => {return  (el !== null)}).length > 0)
											{
												total++;
											}
										}
									}

									return total;
								}
							}"
							x-on:submit="loading = true"
							x-on:filter-complete.window="loading = false, openSlideFilter = false">
								<div class="divide-y divide-gray-100">
									@foreach($filters as $filter)
										@php $i=0; @endphp
										<div class="py-4">
											{{ $filter->render() }}
										</div>
									@endforeach
								</div>
					
								<div class="mt-3 flex justify-between items-center border-t pt-3">
									<button type="button" x-on:click.prevent="$dispatch('reset-filter'), init(), total_filters = 0, openSlideFilter = false" class="text-red-500 text-sm font-semibold">Limpar</button>
									<x-button type="submit" className="btn-primary">Aplicar</x-button>
								</div>
							</form>
						</x-slide-over>
					</div>
				@endif
			</div>

			@livewire('table-resource', [
				'resource_name' => $resource->getName()
			])
		</x-card>
	@endisset
@endsection
