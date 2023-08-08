@extends('admin::resources.resource')

@section('title', $title.' / Cadastrar')

@section('content-resource')
	<form method="POST" class="mb-0" action={{ route($action_routes['store']) }}>
		@csrf

		@include('admin::resources.form')
		
		<button loading type="submit" class="btn btn-success text-white"><i class="la la-check"></i> Salvar</button>
	</form>
@endsection
