{{-- @extends('laraguard::layout', ['breadcrumbs' => []]) --}}
@extends('laraguard::layout')

@section('title', $resource->getTitle())

@section('buttons-title-page')

	@if($placeholder_search)
		<div class="hidden sm:block sm:w-[220px] md:w-[300px]">
			<x-admin::table-search placeholder="{{ $placeholder_search }}" />
		</div>
	@endif

	<div x-data="{openSlideFilter: false, total_filters: 0}"
		x-on:set-total-filter.window="total_filters = $event.detail.total"
		x-on:reset-filter.window="total_filters = 0">
		<x-element::button context="light"  type="button" x-on:click="openSlideFilter = true">
			<x-element::icon name="funnel" class="w-5 h-5"/>  
			
			<span x-cloak x-show="total_filters > 0" class="absolute justify-center flex items-center right-0 top-0 h-4 w-4 -translate-y-1/2 translate-x-1/2 transform rounded-full bg-orange-300 ring-2 ring-white">
				<span class="text-[12px] text-white" x-text="total_filters"></span>
			</span>
		</x-element::button>
		
		<x-element::slide-over idSlide="openSlideFilter" title="Filtros">
			<form @submit.prevent="$dispatch('filter', {filters: filters}, $dispatch('set-total-filter', {total: total_filters}))" 
				x-data="{filters: {}, total_filters: 0, loading: false}"
				x-on:submit="loading = true"
				x-on:reset-filter.window="openSlideFilter = false"
				x-on:filter-complete.window="loading = false, openSlideFilter = false">
				<div class="">
					@foreach($filters as $filter)
						@php $i=0; @endphp
						<div class="py-4">
							{{-- {{ $field->render($filters) }} --}}
						</div>
					@endforeach
				</div>
	
				<div class="mt-3 flex justify-between items-center border-t pt-3">
					<button type="button" wire:click.prevent="resetFilter" class="text-red-500 text-sm font-semibold">Limpar</button>
					<x-element::button type="submit" className="btn-primary">Aplicar</x-element::button>
				</div>
			</form> 
		</x-element::slide-over>
	</div>

	@if($reports)
		<div x-data="{modalReport: false}">
			<x-element::button context="secondary"  type="button" x-on:click="modalReport = true">
				<x-element::icon name="document-chart-bar" class="w-5 h-5"/>
				
				<span class="hidden md:block">Relatórios</span>
			</x-element::button>

			<x-element::modal idModal="modalReport" title="Relatórios disponíveis:">
				<div class="space-y-2">
					@foreach($reports as $report)
						<a class="bg-gray-100 group font-semibold transition-colors text-gray-800 hover:bg-gray-200 rounded-lg flex justify-between items-center p-4" href="{{ route($resource->getRouteName('relatorio'), ['slug' => $report->getSlug()]) }}">
							{{ $report->getTitle() }}
							<x-element::icon name="arrow-right" class="text-gray-400 h-5 opacity-0 group-hover:opacity-100 transition-opacity"></x-element::icon>
						</a>
					@endforeach
				</div>
			</x-element::modal>
		</div>
	@endif
	
	@if($resource->hasAction('create'))
		<x-element::link context="success" class="m-0" href="{{ route($resource->getRouteName('create')) }}">
			<x-element::icon name="plus" class="h-5 w-5" />
			
			<span class="hidden md:block">Cadastrar</span>
		</x-element::link>
	@endif

@endsection

@section('content')

	@if($placeholder_search)
		<div class="mb-4 sm:hidden">
			<x-admin::table-search placeholder="{{ $placeholder_search }}" />
		</div>
	@endif

	<div class="space-y-4">
		<x-element::message.flash all />

		<x-element::card :padding=false class="bg-white">
			@livewire('table-resource', [
				'resource_slug' => $resource->getSlug()
			])
		</x-element::card>
	</div>


	{{-- <x-alert/> --}}

	{{-- @if($table = $resource->getTable())

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
					<div class="relative inline-block text-left"
						x-data="{openSlideFilter: false, total_filters: 0}"
						x-on:set-total-filter.window="total_filters = $event.detail.total"
						x-on:reset-filter.window="total_filters = 0">
						<x-button type="button" className="btn-light" x-on:click="openSlideFilter = true">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
								<path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
							</svg>
							
							<span x-cloak x-show="total_filters > 0" class="absolute justify-center flex items-center right-0 top-0 h-4 w-4 -translate-y-1/2 translate-x-1/2 transform rounded-full bg-orange-300 ring-2 ring-white">
								<span class="text-[12px] text-white" x-text="total_filters"></span>
							</span>
							
						</x-button>

			
						<x-slide-over id="openSlideFilter" title="Filtros">
							@livewire('form-filter', [
								'resource_name' => $resource->getName()
							])
						</x-slide-over>
					</div>
				@endif
			</div>

			@livewire('table-resource', [
				'resource_name' => $resource->getName()
			])
		</x-card>
	@endisset --}}
@endsection
