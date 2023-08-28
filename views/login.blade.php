@extends('admin::auth')

@section('title', 'Painel Administrativo')

@section('auth-content')

	<p class="text-center mb-4 text-sm leading-6 text-gray-500">
		Entre com seu usuário e senha:</a>
    </p>

	<form class="space-y-6" method="POST" action="{{ route(S4mpp\Laraguard\Routes::attemptLogin()) }}">
		@csrf
		
		<x-input type="text" placeholder="nome@email.com" :required=true name="email" title="E-mail">{{ request()->email ?? null }}</x-input>

		<x-input type="password" :required=true name="password" title="Senha"></x-input>

		<x-button full type="submit">Entrar</x-button>
  		
	</form>

	<p class="mt-10 text-center text-sm text-gray-500">Esqueceu sua senha?
		<a href="{{route(S4mpp\Laraguard\Routes::forgotPassword()) }}" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Recuperar</a>
	</p>

	 

@endsection
