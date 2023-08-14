@if($actions)
	@foreach($actions as $action)
		@if(!in_array($local, $action->show_in))
			@continue
		@endif
		
		@if($action->method == 'GET')
			<a class="btn {{ $class }} {{ $element }}-{{ $action->context }} " href="{{ route($actionRoutes[$action->route], ['id' => $id]) }}"><i class="la la-{{ $action->icon }}"></i> {{ $action->title }}</a>
		@else
			<form 
			@isset($action->question)
				onsubmit="return window.confirm('{{ $action->question }}')"
			@endisset
			class="float-none d-inline" method="POST"  action="{{ route($actionRoutes[$action->route], ['id' => $id]) }}">
				@method(strtoupper($action->method))
				@csrf
				<button type="submit" class="btn {{ $class }} {{ $element }}-{{ $action->context }} "><i class="la la-{{ $action->icon }}"></i> {{ $action->title }}</a></button>
			</form>
		@endif
	@endforeach
@endif