@extends('admin::resources.resource')

@section('title', 'Visualizar')

@section('title-page')
	{{-- @include('admin::resources.actions') --}}
	@include('admin::resources.custom-actions')
@endsection 

@section('content-resource')

	<x-alert/>

	<div class="overflow-hidden rounded-lg bg-white border">
		<div class="flex flex-col md:flex-row  ">
			<div class=" w-full md:w-8/12  xl:w-9/12">
				<dl class="divide-y divide-gray-200">
					@foreach($read ?? [] as $element)
						{{ $element->render($register ?? null) }}
					@endforeach
				</dl>
			</div>
			<div class="bg-gray-100 w-full md:w-4/12 xl:w-3/12">
				<div class="sm:p-6 flex justify-between md:flex-col">

					<x-item-view title="ID">#{{ Str::padLeft($register->id, 5, '0') }}</x-item-view>
					
					@if($register->timestamps)
				
						<x-item-view title="Cadastrado em">{{ $register->created_at->format('d/m/Y H:i') }} ({{ $register->created_at->diffForHumans(['short' => true]) }})</x-item-view>
					
						<x-item-view title="Última alteração em">{{ $register->updated_at->format('d/m/Y H:i') }} ({{ $register->updated_at->diffForHumans(['short' => true]) }})</x-item-view>
					@endif
				</div>
			</div>
		</div>
	</div>
	 
@endsection
