@extends('admin::resources.resource')

@section('title', 'Editar')

@section('title-page')
	
@endsection 

@section('content-resource')

	@livewire('form', [
		'resource_name' => $resource->name,
		'id' => $register->id
	])

	{{-- <form method="POST" class="mb-0" action={{ route($routes['save'], ['id' => $register->id]) }} x-data="{loading: false}" x-on:submit="loading = true">
		@csrf
		@method('PUT')

		<div class="overflow-hidden sm:rounded-lg bg-white border-t border-b sm:border-l sm:border-r  mb-6">
			@include('admin::resources.form')
		</div>

		@dump($repeaters)
			<x-repeater :repeater=$repeater />
		@endforeach

		<div class="px-4 sm:px-0">
			<x-button type="submit" className="btn-primary">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
					<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
				</svg>
				
				<span>Salvar</span>
			</x-button>
		</div>
	</form> --}}
@endsection