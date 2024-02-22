@extends('laraguard::layout')

@section('title', 'Read')

@section('content')

	@if($custom_actions)
		@include('admin::custom-actions.action-buttons', ['custom_actions' => $custom_actions])
	@endif
	

	<div class="flex justify-start gap-5 my-5">
		<span class="text-xs text-gray-500"><span class="font-semibold">ID</span> #{{ Str::padLeft($register->id, 5, '0') }}</span>
		
		@isset($register->created_at)
            <span class="text-xs text-gray-500"><span class="font-semibold">Cadastrado em</span> {{ $register->created_at?->format('d/m/Y H:i') }} ({{ $register->created_at?->diffForHumans(['short' => true]) }})</span>
        @endisset

        @isset($register->updated_at)
            <span class="text-xs text-gray-500"><span class="font-semibold">Última alteração em</span> {{ $register->updated_at?->format('d/m/Y H:i') }} ({{ $register->updated_at?->diffForHumans(['short' => true]) }})</span>
        @endisset
	</div>


	{{-- <x-alert/> --}}

	<div class="space-y-4 mb-4">
		@foreach($read as $card)
			<x-element::card title="{{ $card->getTitle() }}" :padding=false className="bg-white">
				<div class="divide-y">
					@foreach($card->getElements() as $item)
						<div class="p-4 sm:gap-4 sm:p-3 xl:p-6 xl:grid xl:grid-cols-12">
							<div class="text-sm font-medium text-slate-900 xl:col-span-2">{{ $item->getTitle() }}</div>
							<div @class([
								'text-sm font-normal text-slate-700 xl:col-span-10',
								'font-semibold' => method_exists($item, 'getIsStrong') && $item->getIsStrong()
							])>
								{{-- @if($item->getDefaultText() && is_null($item->getValue($register)))
									<span class="opacity-60">{{ $item->getDefaultText() }}</span>
								@elseif(method_exists($item, 'renderView'))
									{{ $item->renderView($item->getValue($register), $register) }}
								@else
									{{ $item->getValue($register) }}
								@endif --}}
						
								{{ $item->showContent($register->{$item->getField()}) }}
							</div>
						</div>
					@endforeach
				</div>
			</x-element::card>
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
