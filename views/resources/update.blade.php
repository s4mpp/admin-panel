@extends('admin::resources.resource', ['breadcrumbs' => [
	[$title, route($routes['index'])],
	['Editar', ''],
]])

@section('title', 'Editar')

@section('title-page')


	<div x-data="{loading: false}">
		<x-link x-on:click="loading = true" href="{{ isset($routes['read']) ? route($routes['read'], ['id' => $register->id]) : route($routes['index']) }}" className="">

			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
				<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
			</svg>

			<span>Voltar</span>
		</x-link>
	</div>
@endsection

@section('content-resource')

	<form method="POST" class="mb-0" action={{ route($routes['save'], ['id' => $register->id]) }} x-data="{loading: false}" x-on:submit="loading = true">
		@csrf
		@method('PUT')

		<div class="overflow-hidden rounded-lg bg-white border mb-6">
			@include('admin::resources.form')
		</div>
	
		<x-button type="submit" className="btn-primary">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
				<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
			</svg>
			
			<span>Salvar</span>
		</x-button>
	</form>
@endsection