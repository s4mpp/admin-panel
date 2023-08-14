@extends('admin::layout')

@section('title', $title)

@section('title-page')

	@if(in_array('create', $actions))
		<a href="{{ route($action_routes['create']) }}" class="btn btn-success me-2 text-white"><i class="la la-plus"></i> Cadastrar</a>
	@endif

@endsection

@section('content')

@section('content')

	@isset($table)
		<x-admin-table :collection=$data_table :columns=$table :actions=$resource_actions :actionRoutes=$action_routes />
	@endisset


@endsection
