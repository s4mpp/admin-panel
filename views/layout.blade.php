@extends('admin::html', ['color' => 'bg-gray-50'])

@php
	$guard = config('admin.guard', 'web');

	$navigations = S4mpp\AdminPanel\AdminPanel::getNavigation();
@endphp

@section('main-content')

<div x-data="{ menuOfCanvasMobile: false }" @keydown.window.escape="menuOfCanvasMobile = false">
	<div x-cloak x-show="menuOfCanvasMobile" class="relative z-50 lg:hidden" role="dialog" aria-modal="true">
	  <div 
	  	x-cloak
	  	x-show="menuOfCanvasMobile"
		x-transition:enter="transition-opacity ease-linear duration-300" 
		x-transition:enter-start="opacity-0" 
		x-transition:enter-end="opacity-100" 
		x-transition:leave="transition-opacity ease-linear duration-300" 
		x-transition:leave-start="opacity-1000"
		x-transition:leave-end="opacity-0" 
	  class="fixed inset-0 bg-slate-900/80" ></div>
  
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
  
		  <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-indigo-600 px-6 pb-4">
			<div class="flex h-16 shrink-0 items-center">
				@if(file_exists('images/logo.png'))
					<img class="h-8 w-auto" src="{{ asset('images/logo.png') }}" alt="{{ env('APP_NAME') }}">
				@else
					<h1 class="font-bold text-lg text-center text-white">{{ env('APP_NAME')  }}</h1>
				@endif
			</div>
			<nav class="flex flex-1 flex-col">
			  <ul role="list" class="flex flex-1 flex-col gap-y-7">

				@foreach ($navigations ?? [] as $navigation)
					@continue(!$navigation->items)
					
					<li>
						@if($navigation->title)
							<div class="text-xs font-semibold leading-6 text-indigo-200">{{ $navigation->title }}</div>
						@endif

						<ul role="list" class="-mx-2 mt-2 space-y-1">
							@foreach ($navigation->items as $item)
							<li>
								<a 
								@class([
									'text-indigo-200  group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold',
									'hover:text-white hover:bg-indigo-700' => !$item->active,
									'bg-indigo-700 text-white' => $item->active,
								])
								href="{{ $item->route ?? '#' }}">
						
									<svg class="h-6 w-6 shrink-0 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
										<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
									</svg>
									
									<span class="truncate">{{ $item->title }}</span>
								</a>
								</li>
							@endforeach
						</ul>
					</li>
				@endforeach






				{{-- <li class="mt-auto">
				  <a href="#" class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-indigo-200 hover:bg-indigo-700 hover:text-white">
					<svg class="h-6 w-6 shrink-0 text-indigo-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
					  <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
					  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
					</svg>
					Settings
				  </a>
				</li> --}}
			  </ul>
			</nav>
		  </div>
		</div>
	  </div>
	</div>
  
	<!-- Static sidebar for desktop -->
	<div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
	  <!-- Sidebar component, swap this element with another sidebar if you like -->
	  <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-indigo-600 px-6">
		
		<div class="flex h-16 shrink-0 items-center">
			@if(file_exists('images/logo.png'))
				<img class="h-8 w-auto" src="{{ asset('images/logo.png') }}" alt="{{ env('APP_NAME') }}">
			@else
				<h1 class="font-bold text-lg text-center text-white">{{ env('APP_NAME')  }}</h1>
			@endif
		</div>
		
		<nav class="flex flex-1 flex-col">
		  <ul role="list" class="flex flex-1 flex-col gap-y-7">
			@foreach ($navigations ?? [] as $navigation)
				@continue(!$navigation->items)
				
				<li>
					@if($navigation->title)
						<div class="text-xs font-semibold leading-6 text-indigo-200">{{ $navigation->title }}</div>
					@endif

					<ul role="list" class="-mx-2 mt-2 space-y-1">
						@foreach ($navigation->items as $item)
						<li>
							<a 
							@class([
								'text-indigo-200  group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition-colors',
								'hover:text-white hover:bg-indigo-700' => !$item->active,
								'bg-indigo-700 text-white' => $item->active,
							])
							href="{{ $item->route ?? '#' }}">
								<svg class="h-6 w-6 shrink-0 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
									<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
							  	</svg>
							  
								<span class="truncate">{{ $item->title }}</span>
							</a>
							</li>
						@endforeach
					</ul>
				</li>
			@endforeach

			<li class="-mx-6 mt-auto">
				<div class="inline-flex w-full justify-between items-center gap-x-4 px-6 py-3 text-sm font-semibold leading-6 text-white">
				<div class="inline-flex gap-2 ">
					<span class="inline-block h-6 w-6 overflow-hidden rounded-full bg-slate-100">
					<svg class="h-full w-full text-slate-300" fill="currentColor" viewBox="0 0 24 24">
						<path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
					</svg>
					</span>
				  <span aria-hidden="true">{{ Str::words(auth()->guard(config('admin.guard'))->user()->name, 1, '') }}</span>
				</div>

				  <a href="{{ route(S4mpp\Laraguard\Routes::logout()) }}" class="rounded-full bg-red-100 p-2 text-red-500 hover:bg-red-200 ">
 					
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
						<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
					</svg>
				</a>
				</div>
			</li>





			{{-- <li class="mt-auto">
			  <a href="#" class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-indigo-200 hover:bg-indigo-700 hover:text-white">
				<svg class="h-6 w-6 shrink-0 text-indigo-200 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
				  <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
				  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
				</svg>
				Settings
			  </a>
			</li> --}}
		  </ul>
		</nav>
	  </div>
	</div>
  
	<div class="lg:pl-72">

		<div class="sticky top-0 z-40 flex items-center gap-x-6 bg-indigo-600 px-4 py-4 shadow-sm sm:px-6 lg:hidden">
			<button x-on:click="menuOfCanvasMobile = !menuOfCanvasMobile"  type="button" class="-m-2.5 p-2.5 text-slate-400 lg:hidden">
			  <span class="sr-only">Open sidebar</span>
			  <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
				<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
			  </svg>
			</button>
 				<div class="flex-1 text-sm font-semibold leading-6 text-white">@yield('title')</div>
 			
			<!-- Profile dropdown -->
			<div class="relative" x-data="{ dropdownUserMenu: false }">
				<button x-on:blur="dropdownUserMenu = false;" x-on:click="dropdownUserMenu = !dropdownUserMenu" type="button" class="-m-1.5 flex items-center p-1.5" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
				  <span class="sr-only">Open user menu</span>
				  
				  <span class="inline-block h-6 w-6 overflow-hidden rounded-full bg-slate-100">
					  <svg class="h-full w-full text-slate-300" fill="currentColor" viewBox="0 0 24 24">
						<path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
					  </svg>
					</span>
				  
					<span class="hidden lg:flex lg:items-center">
					<span class="ml-4 text-sm font-semibold leading-6 text-slate-900" aria-hidden="true">{{ Str::words(auth()->guard(config('admin.guard'))->user()->name, 1, '') }}</span>
					<svg class="ml-2 h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
					  <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
					</svg>
				  </span>
				</button>
	
				<div 
					x-show="dropdownUserMenu" x-cloak
				  x-transition:enter="transition ease-out duration-100"
				  x-transition:enter-start="transform opacity-0 scale-95"
				  x-transition:enter-end="transform opacity-100 scale-100"
				  x-transition:leave="transition ease-in duration-75"
				  x-transition:leave-start="transform opacity-100 scale-100"
				  x-transition:leave-end="transform opacity-0 scale-95"
				
				class="absolute divide-y divide-slate-100 right-0 z-10 mt-2.5   origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-slate-900/5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
			  
				<div class="px-4 py-3" role="none">
				  <p class="text-sm" role="none">{{ auth()->guard(config('admin.guard'))->user()->name }}</p>
				  <p class="truncate text-sm font-medium text-slate-900" role="none">{{ auth()->guard(config('admin.guard'))->user()->email }}</p>
				</div>
				<div class="py-1 " role="none">
					<a href="{{ route(S4mpp\Laraguard\Routes::logout()) }}" class="text-red-700 w-full flex justify-between items-center  font-semibold transition-colors px-4 py-2 text-sm bg-red-50 hover:bg-red-100" role="menuitem" tabindex="-1" id="user-menu-item-1">
					  Sair
					  
					  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
						  <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
					  </svg>
				  </a>
				</div>
				</div>
			  </div>
		  
		</div>

  
	  <main class="pb-10 pt-6">
		
		<div class="px-0 sm:px-6 lg:px-8">

			<div class="mb-5 px-4 sm:px-0 ">
				<div>
				  {{-- <nav class="sm:hidden" aria-label="Back">
					<a href="#" class="flex items-center text-sm font-medium text-slate-500 hover:text-slate-700">
					  <svg class="-ml-1 mr-1 h-5 w-5 flex-shrink-0 text-slate-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
						<path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
					  </svg>
					  Voltar
					</a>
				  </nav> --}}

				  @isset($breadcrumbs)

					<nav class="flex" aria-label="Breadcrumb">
						<ol role="list" class="flex items-center space-x-4">
						<li>
							<div>
							<a href="{{ route('dashboard_admin') }}" class="text-slate-400 hover:text-slate-500">
								<svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
								<path fill-rule="evenodd" d="M9.293 2.293a1 1 0 011.414 0l7 7A1 1 0 0117 11h-1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3a1 1 0 00-1-1H9a1 1 0 00-1 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-6H3a1 1 0 01-.707-1.707l7-7z" clip-rule="evenodd" />
								</svg>
								<span class="sr-only">Home</span>
							</a>
							</div>
						</li>

						@foreach($breadcrumbs as $breadcrumb)
							<li>
								<div class="flex items-center">
								<svg class="h-5 w-5 flex-shrink-0 text-slate-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
									<path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
								</svg>
								@if(isset($breadcrumb[1]) && !empty($breadcrumb[1]))
									<a href="{{ $breadcrumb[1] }}" class="ml-4 text-sm font-medium text-slate-500 hover:text-slate-700">{{ $breadcrumb[0] }}</a>
								@else
									<span class="ml-4 text-sm font-medium text-slate-500">{{ $breadcrumb[0] }}</span>
								@endif
								</div>
							</li>
						@endforeach
						</ol>
					</nav>
				@endisset
				  
				  
				</div>
				
				<div class="mt-2 md:flex md:items-center md:justify-between">
				  <div class="min-w-0 flex-1">
					<h2 class="text-2xl font-bold leading-7 text-slate-900 sm:truncate sm:text-3xl sm:tracking-tight">@yield('title')</h2>
				  </div>
				  <div class="mt-4 flex flex-shrink-0 md:ml-4 md:mt-0">
					@yield('title-page')
				  </div>
				</div>
			  </div>
			  
			  <x-alert />


			@yield('content')
		</div>
	  </main>
	</div>
</div>
  
	
@endsection
