@extends('admin::auth')

@section('title', 'Alterar senha')
	
@section('auth-content')
	
	<x-card className="bg-gray-100 mb-4 text-center space-y-3 mt-5">
		<p class="text-xs">E-mail:</p>
		<p class="text-sm font-bold">{{ $user->email }}</p>
	</x-card>
		
	<form class="space-y-4" method="post" action="{{ route(RoutesGuard::identifier('admin-panel')->storePasswordRecovery(), ['token_password_recovery' => $token_password_recovery]) }}" x-data="{loading: false}" x-on:submit="loading = true">
		@csrf
		@method('PUT')
		
		<x-input type="password" :required=true name="password" title="Senha"></x-input>

		<x-input type="password" :required=true name="password_confirmation" title="Digite a nova senha"></x-input>

		<x-button full type="submit" className="btn-primary">Alterar senha</x-button>
	</form>

	<p class="mt-10 text-center text-sm text-gray-500">
		<a tabindex="-1" href="{{route(RoutesGuard::identifier('admin-panel')->login())}}" class="text-gray-600 hover:text-gray-800 text-base">Voltar</a>
	</p>
@endsection