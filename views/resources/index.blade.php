@extends('admin::layout', ['breadcrumbs' => [
	[$title, route($action_routes['index'])],
	['Listar', ''],
]])

@section('title', $title)

@section('title-page')

	@if(in_array('create', $actions))
		<x-link href="{{ route($action_routes['create']) }}">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
				<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd" />
			</svg>

			<span>Cadastrar</span>
		</x-link>
	@endif

@endsection

@section('content')

@section('content')

	@isset($table)
		<x-admin-table :collection=$data_table :columns=$table :actions=$resource_actions :actionRoutes=$action_routes />
	@endisset


@endsection
