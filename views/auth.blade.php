@extends('admin::html')

@section('main-content')
	<div class="px-3 d-flex flex-column justify-content-center laraguard-login">
		<a href="{{ url('/') }}" class="mb-3 d-block mx-auto mt-5">
			<img class="laraguard-img-logo-admin img-fluid px-3 mx-auto" src="{{asset('images/logo.png')}}" alt="{{env('APP_NAME')}}">
		</a>
		<div class="card card-login-admin bg-white mx-auto border-0 mb-4">
			<div class="card-body ">
				<x-alert/>

				<h4 class="text-center mb-1"><strong>@yield('title')</strong></h4>
				
				@yield('auth-content')
			</div>
		</div>
	</div>
@endsection
