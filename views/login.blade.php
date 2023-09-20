@extends('admin::auth')

@section('title', 'Painel Administrativo')

@section('auth-content')

	<p class="text-center mb-4 text-sm leading-6 text-gray-500 bg-primary-500">
		Entre com seu usuário e senha:</a>
    </p>

	<form class="space-y-4" method="POST" action="{{ route(RoutesGuard::identifier('admin-panel')->attemptLogin()) }}" x-data="{loading: false}" x-on:submit="loading = true">
		@csrf
		
		<x-input type="email" placeholder="nome@email.com" :required=true name="username" title="E-mail">{{ old('username') }}</x-input>

		<x-input type="password" :required=true name="password" title="Senha"></x-input>

		<x-button full type="submit" className="btn-primary">Entrar</x-button>
  		
	</form>

	<p class="mt-10 text-center text-sm text-gray-500">Esqueceu sua senha?
		<a href="{{route(RoutesGuard::identifier('admin-panel')->forgotPassword()) }}" class="font-semibold leading-6 text-primary">Recuperar</a>
	</p>
@endsection
