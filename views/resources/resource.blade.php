@extends('admin::layout')

@section('title', $title)

@section('title-page')
 	
	@if($actions && isset($register->id))
	   <div class="inline-flex gap-3" x-data="{loading: false}">
		   @foreach($actions as $action)
			   @if(!in_array('read', $action->show_in))
				   @continue
			   @endif
   
			 	@continue($action->route == 'update' && $current_action == 'update')
				@continue($action->route == 'read' && $current_action == 'read')
				
			   
			   @if($action->method == 'GET')
				   @php
					   $link = route($routes[$action->route], ['id' => $register->id]);
				   @endphp

					 
					<x-link target="{{ $action->new_tab ? '_blank' : null }}" href="{{ $link }}" className="{{ $action->is_danger ?  'bg-red-500 hover:bg-red-600 text-white' : 'btn-primary' }}">

						@switch($action->route)
							@case('update')
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
								<path d="M2.695 14.763l-1.262 3.154a.5.5 0 00.65.65l3.155-1.262a4 4 0 001.343-.885L17.5 5.5a2.121 2.121 0 00-3-3L3.58 13.42a4 4 0 00-.885 1.343z" />
								</svg>
							@break
	
							@case('read')
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
								<path d="M10 12.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" />
								<path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 010-1.186A10.004 10.004 0 0110 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0110 17c-4.257 0-7.893-2.66-9.336-6.41zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
							</svg>
						@endswitch
	
						<span>{{ $action->title }}</span>
					</x-link>
					 
			   @else
				   <form x-data="{loading: false}" x-on:submit="loading = true" target="{{ $action->new_tab ? '_blank' : null }}" 
				   @isset($action->question)
					   onsubmit="return window.confirm('{{ $action->question }}')"
				   @endisset
				   
				   method="POST" action="{{ route($routes[$action->route], ['id' => $register->id]) }}">
					   @method(strtoupper($action->method))
					   @csrf
					   
						<x-button 
						className="{{ $action->is_danger ?  'bg-red-500 hover:bg-red-600 text-white' : 'btn-primary' }}" type="submit">
							@switch($action->route)
								@case('delete')
								<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
									<path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd" />
									</svg>
								@break
							@endswitch

							{{ $action->title }}
						</x-button>
				   </form>
			   @endif
		   @endforeach
	   </div>

	@endif
@endsection 

@section('content')

	@yield('content-resource')
@endsection
