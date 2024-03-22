@extends('laraguard::layout')

@section('title', $resource->getTitle())

@section('buttons-title-page')

	@if($placeholder_search)
		<div class="hidden sm:block sm:w-[220px] md:w-[300px]">
			<x-admin::input-search 
			x-on:keyup.debounce="$dispatch('search', {q: $event.target.value}), searching = true"
			placeholder="{{ $placeholder_search }}" />
		</div>
	@endif

	@if($filters)
		<div x-data="{openSlideFilter: false, total_filters: 0}" x-on:filter-complete.window="openSlideFilter = false">
			
			<x-element::button context="light"  type="button" x-on:click="openSlideFilter = true">
				<x-element::icon name="funnel" class="w-5 h-5"/>  
			
				<span x-cloack x-show="total_filters > 0" class="absolute translate-x-5 -mt-4 rounded-full bg-orange-300 h-4 w-4 justify-center flex items-center">
					<span class="text-[12px] text-white" x-text="total_filters"></span>
				</span>
			</x-element::button>
			
			<x-element::slide-over idSlide="openSlideFilter" title="Filtros">
				
				@include('admin::resources.form-filter')

			</x-element::slide-over>
		</div>
	@endif

	@if($reports)
		<div x-data="{modalReport: false}">
			<x-element::button context="secondary"  type="button" x-on:click="modalReport = true">
				<x-element::icon name="document-chart-bar" class="w-5 h-5"/>
				
				<span class="hidden md:block">Relatórios</span>
			</x-element::button>

			<x-element::modal idModal="modalReport" title="Relatórios disponíveis:">
				<div class="space-y-2">
					@foreach($reports as $report)
						<a class="bg-gray-100 group transition-colors font-semibold text-gray-700 hover:bg-gray-200 rounded-lg flex justify-between items-center p-4" href="{{ route($resource->getRouteName('relatorio'), ['slug' => $report->getSlug()]) }}">
							{{ $report->getTitle() }}
							<x-element::icon name="arrow-right" class="text-gray-400 h-5 opacity-90 group-hover:opacity-100 transition-opacity"></x-element::icon>
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
			<x-admin::input-search 
			x-on:keyup.debounce="$dispatch('search', {q: $event.target.value}), searching = true"
			placeholder="{{ $placeholder_search }}" />
		</div>
	@endif

	<div class="space-y-4">
		<x-element::message.flash all />

		<x-element::card :padding=false class="bg-white">
			@livewire('table-resource', [
				'resource_slug' => $resource->getSlug(),
			])
		</x-element::card>
	</div>
@endsection
