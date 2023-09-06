@extends('admin::auth')

@section('title', 'Recuperar senha')
	
@section('auth-content')

	<p class="text-center mb-4 text-sm leading-6 text-gray-500">
		Insira seu e-mail abaixo para recuperar sua senha:</a>
	</p>
	
	<form class="space-y-4" method="post" action="{{ route(S4mpp\Laraguard\Routes::identifier('admin-panel')->recoveryPassword()) }}" x-data="{loading: false}" x-on:submit="loading = true">
		@csrf

		<x-input type="email" placeholder="nome@email.com"  :required=true name="email" title="E-mail">{{ $user->email ?? null }}</x-input>
		
		<x-button full type="submit" className="btn-primary">Enviar e-mail</x-button>
	</form>
	

	<p class="mt-10 text-center text-sm text-gray-500">
		<a tabindex="-1" href="{{route(S4mpp\Laraguard\Routes::identifier('admin-panel')->login())}}" class="text-gray-600 hover:text-gray-800 text-base">Voltar</a>
	</p>
@endsection