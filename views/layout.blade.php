@extends($panel->layout()->getHtmlFile())

@section('title', $page_title)

@php
	$logo_admin_light = config('admin.logo.light');

@endphp

@section('body')

<div x-data="{ menuOfCanvasMobile: false }" @keydown.window.escape="menuOfCanvasMobile = false">
	<div x-cloak x-show="menuOfCanvasMobile" class="relative z-50 lg:hidden" role="dialog" aria-modal="true">
	  <div
	  	x-cloak
	  	x-show="menuOfCanvasMobile"
		x-transition:enter="transition-opacity ease-linear duration-300"
		x-transition:enter-start="opacity-0"
		x-transition:enter-end="opacity-100"
		x-transition:leave="transition-opacity ease-linear duration-300"
		x-transition:leave-start="opacity-100"
		x-transition:leave-end="opacity-0"
	  class="fixed inset-0 bg-gray-900/80" ></div>

	  <div class="fixed inset-0 flex">

		<div x-show="menuOfCanvasMobile" x-cloak
			x-transition:enter="transition ease-in-out duration-300 transform"
			x-transition:enter-start="-translate-x-full"
			x-transition:enter-end="translate-x-0"
			x-transition:leave="transition ease-in-out duration-300 transform"
			x-transition:leave-start="translate-x-00"
			x-transition:leave-end="-translate-x-full"
			@click.away="menuOfCanvasMobile = false"
		 	class="relative mr-16 flex w-full max-w-xs flex-1">
			<div
				x-show="menuOfCanvasMobile"  x-cloak
				x-transition:enter="ease-in-out duration-300"
				x-transition:enter-start="opacity-0"
				x-transition:enter-end="opacity-100"
				x-transition:leave="ease-in-out duration-300"
				x-transition:leave-start="opacity-1000"
				x-transition:leave-end="opacity-0"
				x-on:click="menuOfCanvasMobile = !menuOfCanvasMobile"
			class="absolute left-full top-0 flex w-16 justify-center pt-5">
				<button type="button" class="-m-2.5 p-2.5">
					<span class="sr-only">Close sidebar</span>
					<svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
						<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
					</svg>
				</button>
			</div>
			@include('admin::navigation')
		</div>
	  </div>
	</div>

	<div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
		@include('admin::navigation')
	</div>

	<div class="lg:pl-72">

		<div class="bg-white shadow-sm sticky top-0 z-40 ">
			<div class="flex items-center justify-between lg:justify-end  gap-x-6  px-4 sm:px-6 ">
			
			<div>
				<button x-on:click="menuOfCanvasMobile = !menuOfCanvasMobile"  type="button" class="-ml-4 py-4 px-4 text-gray-800 lg:hidden ">
				  <span class="sr-only">Open sidebar</span>
				  <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
					<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
				  </svg>
				</button>
			</div>
 				

			<!-- Profile dropdown -->
			<div class="relative" x-data="{ dropdownUserMenu: false }">
				<button  x-on:click="dropdownUserMenu = !dropdownUserMenu" type="button" class="-mx-1.5 py-4 flex items-center px-1.5" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
				  <span class="sr-only">Open user menu</span>

				  <span class="inline-block h-6 w-6 overflow-hidden rounded-full bg-gray-100">
					  <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
						<path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
					  </svg>
					</span>

					<span class="hidden lg:flex lg:items-center">
					<span class="ml-4 text-sm font-semibold leading-6 text-gray-900" aria-hidden="true">{{ Str::words(auth()->guard($panel->getGuardName())->user()->name, 1, '') }}</span>
					<svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
					  <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
					</svg>
				  </span>
				</button>

				<div
				x-on:click.outside="dropdownUserMenu = false;"
					x-show="dropdownUserMenu" x-cloak
				  x-transition:enter="transition ease-out duration-100"
				  x-transition:enter-start="transform opacity-0 scale-95"
				  x-transition:enter-end="transform opacity-100 scale-100"
				  x-transition:leave="transition ease-in duration-75"
				  x-transition:leave-start="transform opacity-100 scale-100"
				  x-transition:leave-end="transform opacity-0 scale-95"

				class="absolute divide-y divide-gray-100 right-0 z-10  min-w-[200px]  origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">

				<div class="px-4 py-3" role="none">
				  <p class="text-sm" role="none">{{ auth()->guard($panel->getGuardName())->user()->name }}</p>
				  <p class="truncate text-sm font-medium text-gray-900" role="none">{{ auth()->guard($panel->getGuardName())->user()->email }}</p>
				</div>
				<div class="py-1 " role="none">
					{{-- @if($route_home)
						<a href="{{ route($route_home) }}" target="_blank" class="text-gray-700 w-full flex justify-between items-center    transition-colors px-4 py-2 text-sm bg-gray-50 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-1">
							Acessar site
						</a>
					@endif --}}


					<a href="{{ route($panel->getRouteName('configuracoes', 'index')) }}" class="text-gray-700 w-full flex justify-between items-center    transition-colors px-4 py-2 text-sm bg-gray-50 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-1">
						Configurações
					</a>


					<a href="{{ $my_account_url }}" class="text-gray-700 w-full flex justify-between items-center    transition-colors px-4 py-2 text-sm bg-gray-50 hover:bg-gray-100" role="menuitem" tabindex="-1" id="user-menu-item-1">
					  Minha conta

				  </a>
					<a href="{{ $logout_url }}" class="text-red-700 w-full flex justify-between items-center  font-semibold transition-colors px-4 py-2 text-sm bg-red-50 hover:bg-red-100" role="menuitem" tabindex="-1" id="user-menu-item-1">
					  Sair

					  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
						  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
					  </svg>
				  </a>
				</div>
				</div>
			  </div>

		</div>
		</div>

	  <main class="pb-10 pt-6 px-4 sm:px-6 ">
				{{-- <div>
					@isset($breadcrumbs)
						@php
							if($section_resource = $resource->getSection())
							{
								$section = \S4mpp\AdminPanel\Navigation::getSection($section_resource)->getTitle();

								array_unshift($breadcrumbs, [$section]);
							}
						@endphp

						<nav class="flex" aria-label="Breadcrumb">
								<ol role="list" class="flex items-center space-x-2">
								<li>
									<div>
										@if($route_start)
											<a href="{{ $route_start }}" class="text-gray-400 hover:text-gray-500">
										@endif
											<svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
												<path fill-rule="evenodd" d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z" clip-rule="evenodd" />
											</svg>
											<span class="sr-only">Home</span>
										@if($route_start)
											</a>
										@endif
									</div>
								</li>

								@foreach(array_filter($breadcrumbs) as $breadcrumb)
									<li>
										<div class="flex items-center">
											<svg class="h-5 w-5 flex-shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
												<path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
											</svg>
											@if(isset($breadcrumb[1]) && !empty($breadcrumb[1]))
												<a href="{{ $breadcrumb[1] }}" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700">{{ $breadcrumb[0] }}</a>
											@else
												<span class="ml-2 text-sm font-medium text-gray-500">{{ $breadcrumb[0] }}</span>
											@endif
										</div>
									</li>
								@endforeach

								<li>
									<div class="flex items-center">
										<svg class="h-5 w-5 flex-shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
											<path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
										</svg>
										<span class="ml-2 text-sm font-medium text-gray-500">@yield('title')</span>
									</div>
								</li>
							</ol>
						</nav>
					@endisset
				</div> --}}

				<div>
					<div class="flex" aria-label="Breadcrumb">
						<div class="flex items-center space-x-2">
							<div class="text-gray-400 ">
								{{-- <a href="#" class="text-gray-400 hover:text-gray-500"> --}}
									<svg class="h-4 w-4 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
										<path fill-rule="evenodd" d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z" clip-rule="evenodd" />
									</svg>
									<span class="sr-only">Home</span>
								{{-- </a> --}}
							</div>

							@foreach($breadcrumbs as $breadcrumb)
								<div class="flex items-center">
									<svg class="h-5 w-5 mt-1 flex-shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
										<path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
									</svg>
									
									<span class="ml-2  text-sm font-medium text-gray-500">{{ $breadcrumb->getTitle() }}</span>
								</div>
							@endforeach
						</div>
					</div>
				</div>

				<div class="mt-1 mb-5 flex gap-3 flex-nowrap items-center justify-between">
					<div class="flex-grow min-w-0">
						<h2 class="flex-1 text-2xl font-bold leading-7 truncate block text-gray-900 sm:text-3xl">@yield('title')</h2>
					</div>
					<div class=" shrink sm:order-2 flex-nowrap inline-flex items-center gap-4  justify-end ">
						@yield('buttons-title-page')
					</div>
				</div>

				@yield('content')
	  </main>
	</div>
</div>


@endsection

