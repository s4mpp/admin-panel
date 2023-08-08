@extends('admin::layout')

@section('title', $title.' / Cadastrar')

@section('title-page')
	<a href="{{ route($action_routes['index']) }}" class="btn btn-secondary float-end"><i class="la la-chevron-left"></i> Voltar</a>
@endsection

@section('content')

	@yield('content-resource')
@endsection
