@php
	$alpine_data_filters = [];

	foreach($report->getFields() as $filter)
	{
		$alpine_data_filters[] = $filter->getField().': '.$filter->getAlpineExpression();
	}
@endphp

@extends('admin::layout', ['breadcrumbs' => [
	[$title, route($resource->getRouteName('index'))],
	['Relatórios', null]
]])

@section('title', $report->getTitle())

@section('content')
	<x-card className="bg-white border" :padding=false>
		<div class="flex flex-col sm:flex-row">
			<div class="bg-gray-100 sm:w-[365px] p-4">
				<span class="font-semibold">Filtros</span>
				<div class="clear-both"></div>
				<form @submit.prevent="$dispatch('filter', {filters: filters})" 
						x-data="{loading: false, filters: { {{ join(',', $alpine_data_filters) }} }}"
						x-on:submit="loading = true"
						x-on:filter-complete.window="loading = false">
					<div class="mt-3 divide-y divide-gray-300">
						@foreach($report->getFields() as $field)
							<div class=" py-3">
								{{ $field->render() }}
							</div>
						@endforeach
					</div>
					<x-button full type="submit" className="mt-4 btn-primary">GERAR RELATÓRIO</x-button>
				</form>
			</div>
			<div class="flex-auto">
				<div class="w-full p-3  border-b border-gray-200">
					<span class="font-semibold">Resultado</span>
				</div>
				<div class="p-3 mt-2">
					@livewire('admin-report', [
						'resource_name' => $resource->getName(),
						'report_name' => $report->getSlug()
					])
				</div>
			</div>
		</div>
	</x-card>
@endsection
