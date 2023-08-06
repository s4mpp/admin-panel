@extends('admin::auth')

@section('title', 'Alterar senha')
	
@section('auth-content')
<div class="card-auth-sm mx-auto">
	<div class="card mb-4 bg-light border-0 mt-3">
		<div class="card-body  text-center">
			<p class="mb-0">E-mail: <strong>{{ $user->email }}</strong></p>
		</div>
	</div>

	<form method="post" action="{{ route(S4mpp\Laraguard\Routes::storePasswordRecovery(), ['token_password_recovery' => $token_password_recovery]) }}">
		@csrf
		@method('PUT')
		
		<x-input type="password" :required=true name="password" title="Senha"></x-input>

		<x-input type="password" :required=true name="password_confirmation" title="Digite a nova senha"></x-input>

		<div class="mx-auto d-grid">
			<button loading type="submit" class="btn btn-block btn-primary mt-3">Alterar senha</button>
		</div>
	</form>
</div>
@endsection