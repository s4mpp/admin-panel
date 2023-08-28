@extends('admin::auth')

@section('title', 'Alterar senha')
	
@section('auth-content')
	
	<div class="card mb-4 bg-light border-0 mt-3">
		<div class="card-body  text-center">
			<p class="mb-0">E-mail: <strong>{{ $user->email }}</strong></p>
		</div>
	</div>

	<form class="space-y-6" method="post" action="{{ route(S4mpp\Laraguard\Routes::storePasswordRecovery(), ['token_password_recovery' => $token_password_recovery]) }}">
		@csrf
		@method('PUT')
		
		<x-input type="password" :required=true name="password" title="Senha"></x-input>

		<x-input type="password" :required=true name="password_confirmation" title="Digite a nova senha"></x-input>

		<x-button full type="submit">Alterar senha</x-button>
	</form>

	<p class="mt-10 text-center text-sm text-gray-500">
		<a tabindex="-1" href="{{route(S4mpp\Laraguard\Routes::login())}}" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Voltar</a>
	</p>

@endsection