@extends('admin::layout', ['breadcrumbs' => [
	[$title, route($routes['index'])],
]])


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
	
			
				
			<div class="relative  inline-block text-left" x-data="{dropdownCustomActions : false}">

				@if($custom_actions ?? false)
				
					<x-button type="button" className="btn-secondary" x-on:click="dropdownCustomActions = !dropdownCustomActions">
						<span class="block sm:hidden">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
								<path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
								<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
							</svg>
						</span>
						<span class="hidden sm:block">Ações</span>

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


			<x-link href="{{ $back_url }}" className="ring-inset ring-1 ring-gray-200 btn-muted">

				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
					<path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
				</svg>

				<span class="hidden sm:block">Voltar</span>
			</x-link>
		</div>

		@foreach (array_merge($actions ?? [], $custom_actions ?? []) as $action)
			
			@continue(!$action->question || $action->is_disabled)

			<x-modal 
				idModal="modal{{ Str::camel($action->slug) }}"
				route="{{ route($routes[$action->route], ['id' => $register->id])  }}"
				method="{{ $action->method }}" danger="{{ $action->is_danger }}">{{ $action->question }}</x-modal>
		@endforeach
	</div>
	  
@endsection 

@section('content')

	@yield('content-resource')
@endsection