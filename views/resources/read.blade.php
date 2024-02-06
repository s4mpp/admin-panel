@extends('laraguard::layout')

@section('title', 'Read')

@section('content')

	@if($custom_actions)
		@include('admin::custom-actions.action-buttons', ['custom_actions' => $custom_actions])
	@endif
	

	<div class="flex justify-start gap-5 my-5">
		<span class="text-xs text-gray-500"><span class="font-semibold">ID</span> #{{ Str::padLeft($register->id, 5, '0') }}</span>
		
		@if($register->timestamps)
			<span class="text-xs text-gray-500"><span class="font-semibold">Cadastrado em</span> {{ $register->created_at->format('d/m/Y H:i') }} ({{ $register->created_at->diffForHumans(['short' => true]) }})</span>
			<span class="text-xs text-gray-500"><span class="font-semibold">Última alteração em</span> {{ $register->updated_at->format('d/m/Y H:i') }} ({{ $register->updated_at->diffForHumans(['short' => true]) }})</span>
		@endif
	</div>


	{{-- <x-alert/> --}}

	<div class="space-y-4 mb-4">
		@foreach($resource->getRead() ?? [] as $element)
			{{ $element->render() }}
		@endforeach
	</div>

	{{--<div class="space-y-4 mb-4">
		@foreach($resource->getRepeaters() ?? [] as $repeater)
			<x-card className="card border bg-white" title="{{ $repeater->getTitle() }} ({{ $repeater->getTotalRegisters($resource, $register) }})" :padding=false>
				@livewire('table-repeater', [
					'register_id' => $register->id,
					'resource_name' => $resource->getName(),
					'repeater_name' => $repeater->getRelation()
				])
			</x-card>
		@endforeach
	</div>	  --}}
@endsection
