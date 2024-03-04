@extends('admin::crud.resource')

@section('title', 'Visualizar')

@section('title-page-resource')

	@if($custom_actions)
		@include('admin::custom-actions.custom-actions', ['custom_actions' => $custom_actions])
	@endif
@endsection

@section('content-resource')

	<div class="flex justify-start gap-5 -mt-4 mb-5">
		<span class="text-xs text-gray-500"><span class="font-semibold">ID</span> #{{ Str::padLeft($register->id, 5, '0') }}</span>

		@isset($register->created_at)
            <span class="text-xs text-gray-500"><span class="font-semibold">Cadastrado em</span> {{ $register->created_at?->format('d/m/Y H:i') }} ({{ $register->created_at?->diffForHumans(['short' => true]) }})</span>
        @endisset

        @isset($register->updated_at)
            <span class="text-xs text-gray-500"><span class="font-semibold">Última alteração em</span> {{ $register->updated_at?->format('d/m/Y H:i') }} ({{ $register->updated_at?->diffForHumans(['short' => true]) }})</span>
        @endisset
	</div>

	<x-alert/>

	<div class="space-y-4 mb-4">
		@foreach($resource->getRead() ?? [] as $element)
			{{ $element->render($register ?? null) }}
		@endforeach
	</div>

	<div class="space-y-4 mb-4">
		@foreach($resource->getRepeaters() ?? [] as $repeater)
			<x-card className="card border bg-white" title="{{ $repeater->getTitle() }} ({{ $repeater->getTotalRegisters($resource, $register) }})" :padding=false>
				@livewire('table-repeater', [
					'register_id' => $register->id,
					'resource_name' => $resource->getName(),
					'repeater_name' => $repeater->getRelation()
				])
			</x-card>
		@endforeach
	</div>
@endsection
