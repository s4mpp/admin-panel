@extends('admin::layout')

@section('title', 'Editar usuário')

@section('title-page')
	<a href="{{ route('users_index_admin') }}" class="btn btn-secondary float-end"><i class="la la-chevron-left"></i> Voltar</a>
@endsection

@section('content')
	<form method="POST" class="mb-0">
		@method('PUT')
	
		@include('admin::users.form')
	
		<button loading type="submit" class="btn btn-success text-white"><i class="la la-check"></i> Salvar</button>
	</form>
@endsection
