@extends('laraguard::layout')

@section('title', 'Report')

{{-- @section('title', $report->getTitle()) --}}

@section('content')
	{{-- <x-card className="bg-white border" :padding=false>--}}
		<div class="flex flex-col sm:flex-row">
			<div class="bg-gray-100 sm:w-[365px] p-4">
				<span class="font-semibold">Filtros</span>
				<div class="clear-both"></div>

				@livewire('form-report', [
					'resource_slug' => $resource->getSlug(),
					'report_slug' => $report->getSlug()
				])
			</div>
			<div class="flex-auto">
				<div class="w-full p-3  border-b border-gray-200">
					<span class="font-semibold">Resultado</span>
				</div>
				<div class="p-3 mt-2">
					{{-- @livewire('admin-report', [
						'resource_name' => $resource->getName(),
						'report_name' => $report->getSlug()
					]) --}}
				</div>
			</div>
		</div>
	{{-- </x-card> --}}
@endsection
