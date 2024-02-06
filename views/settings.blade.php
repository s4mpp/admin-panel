@extends('laraguard::layout')

@section('content')

	{{-- @if($register->timestamps)
		<div class="text-xs text-gray-500 mb-4"><span class="font-semibold">Última alteração em</span> {{ $register->updated_at->format('d/m/Y H:i') }} ({{ $register->updated_at->diffForHumans(['short' => true]) }})</div>
	@endif
	
	@livewire('form-settings') --}}

	@livewire('form-settings')
@endsection