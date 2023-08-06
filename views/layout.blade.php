
@extends('admin::html')

@section('main-content')
	@php
		$current_route = request()->path() ?? null;

		$guard = config('admin.guard');

		$navigations = S4mpp\AdminPanel\Navigation\Menu::getNavigations();
	@endphp

	<div class="main bg-light">
		<div class="sidebar bg-primary">
			<div class="p-4">
				<div class="mx-auto w-75 px-3 mb-0">
					<a href="{{ route('dashboard_admin') }}" class="">
						@if(File::exists('images/logo.png'))
							<img  class="img-fluid p-2 " src="{{ asset('images/logo.png') }}" alt="{{ env('APP_NAME') }}">
						@else
							<p class="text-white text-center"><strong>{{  env('APP_NAME')  }}</strong></p>
						@endif
					</a>
				</div>
			</div>			
				
			<div class="menu-sidebar mt-3">
				@foreach ($navigations['sidebar'] ?? [] as $navigation)
					
 					<p class="text-secondary mt-4 mb-1 px-4"><span class="px-2"><strong>{{ $navigation->title }}</strong></span></p>
					
					@foreach ($navigation->items as $menu)
						<div class="px-3 w-100 clearfix">
							<a 
							@class([
								'w-100',
								'float-start',
								'mb-1',
								'rounded',
								'text-decoration-none',
								'px-2',
								'd-flex',
								'align-content-center',
								'active' => ($menu->uri && (strpos($current_route, $menu->uri) !== false))
							])
							href="{{ $menu->action ? route($menu->action) : '#' }}">
								<span class="px-2 py-2 w-100 d-flex align-items-center"> <i class="la {{ $menu->icon }}"></i> {{ $menu->title }}</span>
							</a>
						</div>
					@endforeach
				@endforeach
			</div>
		</div>
		<header class="bg-white position-fixed pt-2 pb-2 px-2 px-md-3 d-flex justify-content-between">
			
			<a href="#" class="text-decoration-none align-middle sidebar-toggler d-flex justify-content-center">
				<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
					<path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
				  </svg>
			</a>

			<h3 class="mb-0 ms-1 pb-0 flex-fill align-self-center text-muted text-center text-md-start"><strong>@yield('title')</strong></h3>
				
			<div class="menu-header mt-1 d-flex justify-content-end align-self-center ">
				
				<div class="dropdown ">
					<a class="text-decoration-none dropdown-toggle pe-2" href="#" role="button"
						data-bs-toggle="dropdown">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
							<path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
							<path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
						  </svg>
					</a>

					<ul class="dropdown-menu dropdown-menu-end p-0 dropdown-user">
						<li class="bg-light rounded-top">
							<div class="p-3 text-dark">
								<p class="mb-0 text-nowrap">{{ auth()->guard(config('admin.guard'))->user()->name }}</p>
								<p class="mb-0 text-nowrap"><strong>{{ auth()->guard(config('admin.guard'))->user()->email }}</strong></p>
							</div>
						</li>
						{{-- <li><a class="dropdown-item pt-2 pb-2" href="{{ route('change_password_admin') }}"> Alterar senha <i class="la text-muted float-end mt-1 la-lock"></i></a></li> --}}
						<li>
							<hr class="p-0 m-0 dropdown-divider">
						</li>
						<li>
							<a class="dropdown-item rounded-bottom pt-2 pb-2 text-danger" href="{{ route(S4mpp\Laraguard\Routes::logout()) }}">
								<span class="float-start"><strong>Sair</strong></span>
								<span class="float-end"><i class="la la-sign-out"></i></span><div class="clearfix"></div>	
							</a>
						</li>
					</ul>
				</div>
			</div>
		</header>

		<div class="content-admin px-3 px-md-4 ">
			<div class="content mb-3">

                <div class="admin-actions px-md-0 d-flex justify-content-start mb-3 flex-fill">

                    @yield('title-page')
                </div>

				<x-alert/>
				
				@yield('content')
			</div>
		</div>
	</div>
@endsection
