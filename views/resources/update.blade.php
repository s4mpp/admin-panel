@extends('admin::resources.resource', ['breadcrumbs' => [
	[$title, route($routes['index'])],
	['Editar', ''],
]])

@section('title', 'Editar')

@section('content-resource')

	<form method="POST" class="mb-0" action={{ route($routes['save'], ['id' => $register->id]) }}>
		@csrf
		@method('PUT')

		@include('admin::resources.form')
	
		<x-button type="submit">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
				<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
			</svg>
			
			<span>Salvar</span>
		</x-button>
	</form>
@endsection