@extends('admin::html')

@section('main-content')

	<div class="bg-primary">
		<div class="px-3 d-flex flex-column justify-content-center admin-login" style="background-color: rgba(255, 255, 255, 0.8)">
			<div class="card admin-card-login-admin bg-white mx-auto border-0 mb-4">
				<a href="{{ url('/') }}" class="p-3 w-50 bg-primary rounded shadow d-block mx-auto mt-n4 mb-2">
					<img class="admin-img-logo img-fluid px-3 mx-auto" src="{{asset('images/logo.png')}}" alt="{{env('APP_NAME')}}">
				</a>
				<div class="card-body mt-0">
					<x-alert/>

					<h4 class="text-center mb-1"><strong>@yield('title')</strong></h4>
					
					@yield('auth-content')
				</div>
			</div>
		</div>
	</div>
@endsection
