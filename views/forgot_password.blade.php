@extends('admin::auth')

@section('title', 'Recuperar senha')
	
@section('auth-content')

	<p class="text-center mb-4 text-sm leading-6 text-gray-500">
		Insira seu e-mail abaixo para recuperar sua senha:</a>
	</p>
	
	<form class="space-y-6" method="post" action="{{ route(S4mpp\Laraguard\Routes::recoveryPassword()) }}">
		@csrf

		<x-input type="email" placeholder="nome@email.com"  inputGroupStart='<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
			<path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
			</svg>' :required=true name="email" title="E-mail">{{ $user->email ?? null }}</x-input>
		
		<x-button type="submit">Enviar e-mail</x-button>
	</form>
	

	<p class="mt-10 text-center text-sm text-gray-500">
		<a tabindex="-1" href="{{route(S4mpp\Laraguard\Routes::login())}}" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Voltar</a>
	</p>
@endsection