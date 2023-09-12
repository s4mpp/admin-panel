@extends('admin::layout')

@php

	$data_modals = [];
	foreach(array_merge($actions ?? [], $custom_actions ?? []) as $action)
	{
		if($action->question && !$action->is_disabled)
		{
			$data_modals[] = 'modal'.Str::camel($action->slug).': false';
		}
	}
@endphp

@section('title', $title)

@section('title-page')

	<div x-data="{ {{ join(',', $data_modals) }} }">

		<div class="inline-flex gap-3">
	
			@foreach ($actions ?? [] as $action)

				{{-- TO-DO: colocar no metodo getRoutes --}}
				@if(!in_array($current_action, $action->show_in))
					@continue
				@endif

				@if($action->question)
					<x-link href="#" x-on:click="modal{{ Str::camel($action->slug) }} = true" className="{{ $action->is_danger ?  'bg-red-500 hover:bg-red-600 text-white' : 'btn-primary' }}">
						{{ $action->title }}
					</x-link>

 				@else
					@if($action->method == 'GET')
						<x-link href="{{ route($routes[$action->route], ['id' => $register->id]) }}" target="{{ $action->new_tab ? '_blank' : null }}"  className="{{ $action->is_danger ?  'bg-red-500 hover:bg-red-600 text-white' : 'btn-primary' }}">		
							{{ $action->title }}
						</x-link>
					@else
						<form x-data="{loading: false}" x-on:submit="loading = true" target="{{ $action->new_tab ? '_blank' : null }}" 
							method="POST" action="{{ route($routes[$action->route], ['id' => $register->id]) }}">
							@method(strtoupper($action->method))
							@csrf
							
							<x-button 
							className="{{ $action->is_danger ?  'bg-red-500 hover:bg-red-600 text-white' : 'btn-primary' }}" type="submit">	
								{{ $action->title }}
							</x-button>
						</form>
					@endif
				@endif
			@endforeach
				
				<div class="relative  inline-block text-left" x-data="{dropdownCustomActions : false}">

					@if($custom_actions ?? false)
					
					<x-button type="button" className="btn-secondary" x-on:click="dropdownCustomActions = !dropdownCustomActions">
						Ações

						<svg class="-mr-1 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
							<path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
						</svg>
					</x-button>
			 
		
					<div x-on:click.outside="dropdownCustomActions = false;"
						x-cloak
						x-show="dropdownCustomActions"
						x-transition:enter="transition ease-out duration-100"
						x-transition:enter-start="transform opacity-0 scale-95"
						x-transition:enter-end="transform opacity-100 scale-100"
						x-transition:leave="transition ease-in duration-75"
						x-transition:leave-start="transform opacity-100 scale-100"
						x-transition:leave-end="transform opacity-0 scale-95"
					class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
						<div class="py-1" role="none">

							@foreach ($custom_actions ?? [] as $action)

								@if($action->is_disabled)

									<div data-tippy-content="{{ $action->disabled_message }}" >
										<button disabled type="button" class="text-gray-700/50 cursor-not-allowed w-full text-start block px-4 py-2 text-sm">
											{{ $action->title }}
										</button>
									</div>

									@continue
								@endif

								@if($action->question)
									<a href="#" x-on:click="modal{{ Str::camel($action->slug) }} = true, dropdownCustomActions = false" class="text-gray-700 hover:bg-gray-100 hover:text-gray-900 block px-4 py-2 text-sm">{{ $action->title }}</a>
								@else
									@if($action->method == 'GET')
										<div x-data="{loading: false}">
											<a href="{{ route($routes[$action->route], ['id' => $register->id]) }}" class="text-gray-700 hover:bg-gray-100 hover:text-gray-900 block px-4 py-2 text-sm">{{ $action->title }}</a>
										</div>
									@else
										<form x-data="{loading: false}" x-on:submit="loading = true" action="{{ route($routes[$action->route], ['id' => $register->id]) }}" method="POST">
											@csrf
											@method($action->method)
											<button type="submit" class="text-gray-700 hover:bg-gray-100 hover:text-gray-900 w-full text-start block px-4 py-2 text-sm">{{ $action->title }}</button>
										</form>
									@endif
								@endif
							@endforeach
						</div>
					</div>
					@endif
				</div>


		<x-link href="{{ $back_url }}" className="ring-inset ring-1 ring-gray-200 btn-muted">

			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
				<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
			</svg>

			<span>Voltar</span>
		</x-link>
		</div>

		@foreach (array_merge($actions ?? [], $custom_actions ?? []) as $action)
			
			@continue(!$action->question || $action->is_disabled)

			<div class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-cloak x-show="modal{{ Str::camel($action->slug) }}">
				<div
					x-cloak
					x-show="modal{{ Str::camel($action->slug) }}"
					x-transition:enter="ease-out duration-300"
					x-transition:enter-start="opacity-0"
					x-transition:enter-end="opacity-100"
					x-transition:leave="ease-in duration-200"
					x-transition:leave-start="opacity-100"
					x-transition:leave-end="opacity-0"
				class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
			
				<div class="fixed inset-0 z-10 w-screen overflow-y-auto">
				<div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

					<div
					x-cloak
					x-show="modal{{ Str::camel($action->slug) }}"
					x-transition:enter="ease-out duration-300" 
					x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
					x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
					x-transition:leave="ease-in duration-200" 
					x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
					x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
					class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
					
					<div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
						<div class="sm:flex sm:items-start">
						<div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full sm:mx-0 sm:h-10 sm:w-10 {{ $action->is_danger ? ' bg-red-100' : ' bg-gray-100' }}">
							<svg class="h-6 w-6 {{ $action->is_danger ? ' text-red-600' : ' text-gray-600' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
							<path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
							</svg>
						</div>
						<div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
							<h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">{{ $action->title }}</h3>
							<div class="mt-2">
							<p class="text-sm text-gray-500">{{ $action->question }}</p>
							</div>
						</div>
						</div>
					</div>
					<div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-4">
						@if($action->method == 'GET')
							<div x-data="{loading: false}" >
								<x-link x-on:click="loading = true"  href="{{ route($routes[$action->route], ['id' => $register->id]) }}" className="{{ $action->is_danger ?  'bg-red-500 hover:bg-red-600 text-white' : 'btn-primary' }}">Continuar</x-link>
							</div>
						@else
							<form action="{{ route($routes[$action->route], ['id' => $register->id]) }}" method="POST" x-data="{loading: false}" x-on:submit="loading = true" >
								@csrf
								@method($action->method)
								<x-button  className="{{ $action->is_danger ?  'bg-red-500 hover:bg-red-600 text-white' : 'btn-primary' }}">Continuar</x-button>
							</form>
						@endif
						<x-button type="button" x-on:click="modal{{ Str::camel($action->slug) }} = false" className="ring-inset ring-1 ring-gray-200 btn-muted">Voltar</x-button>
					</div>
					</div>
				</div>
				</div>
			</div>
			
		@endforeach
	</div>
	  
@endsection 

@section('content')

	@yield('content-resource')
@endsection