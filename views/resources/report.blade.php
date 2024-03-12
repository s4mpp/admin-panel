@extends('laraguard::layout')

@section('title', $report->getTitle())

{{-- @section('title', $report->getTitle()) --}}

@section('content')
	<div class="flex flex-col sm:flex-row gap-4">
		<div class="sm:w-[400px]">
			<x-element::card class="bg-white" :padding=false  title="Filtros">
				<div class="px-6 pb-6">
					@include('admin::resources.form-filter')
				</div>
			</x-element::card>
		</div>
		<div class="flex-auto">
			@livewire('report-result', [
				'resource_slug' => $resource->getSlug(),
				'report_slug' => $report->getSlug(),
			])
		</div>
	</div>
@endsection
