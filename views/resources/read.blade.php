@extends('laraguard::layout')

@section('title', 'Visualizar')

@section('buttons-title-page')
	@if($custom_actions)
		<div x-data="{ {{ join(',', array_merge($custom_action_slides ?? [], $custom_actions_modals ?? [])) }} }">
			@foreach ($custom_action_elements as $action)
				@continue($action->isDisabled())
		
				@if($action->hasConfirmation())
					@php
						$is_danger = $action->isDangerous()
					@endphp
					<x-element::modal :danger=$is_danger
						title="{{ $action->getTitle() }}"
						subtitle="{{ $action->getMessageConfirmation() }}"
						idModal="{{ $action->getNameModalConfirmation() }}">
		
						<x-dynamic-component :component="$action->getComponentName('confirmation')" :action=$action />
					</x-element::modal>
				@endif
		
				@if($content_component = $action->getComponentName('content'))
					<x-dynamic-component :component="$content_component" :action=$action />
				@endif
			@endforeach
			
			<x-element::dropdown position="right">
				<x-slot:button>
					<x-element::button x-on:click="dropdown = !dropdown"> <span>Ações</span>
						<x-element::icon class=" w-5 h-5 mt-0.5" name="chevron-down" solid mini />
					</x-element::button>
				</x-slot:button>
				
				<x-slot:body class="py-1 divide-y min-w-56">
					@foreach ($custom_actions as $group)
						<div>
							@if(!is_array($group))
								@php
									$group = [$group];
								@endphp
							@endif
		
							@foreach($group as $action)
								@if($action->isDisabled())
									<x-element::dropdown.button disabled data-tippy-content="{{ $action->getDisabledMessage() }}"><span class="py-1 block">{{ $action->getTitle() }}</span></x-element::dropdown.button>
									
									@continue
								@endif
		
								@if($action->hasConfirmation())
									<x-element::dropdown.button x-on:click="dropdown = false, {{ $action->getNameModalConfirmation() }} = true"><span class="py-1 block">{{ $action->getTitle() }}</span></x-element::dropdown.button>
								@else
									<x-dynamic-component :component="$action->getComponentName('button')" :action=$action />
								@endif
							@endforeach
						</div>
					@endforeach
				</x-slot:body>
			</x-admin::dropdown>
		</div>
	@endif
@endsection

@section('content')

	<x-element::message.flash />
	<x-element::message.error />


	<div class="flex justify-start gap-5 my-5">
		<span class="text-xs text-gray-500"><span class="font-semibold">ID</span> #{{ Str::padLeft($register->id, 5, '0') }}</span>
		
		@isset($register->created_at)
            <span class="text-xs text-gray-500"><span class="font-semibold">Cadastrado em</span> {{ $register->created_at?->format('d/m/Y H:i') }} ({{ $register->created_at?->diffForHumans(['short' => true]) }})</span>
        @endisset

        @isset($register->updated_at)
            <span class="text-xs text-gray-500"><span class="font-semibold">Última alteração em</span> {{ $register->updated_at?->format('d/m/Y H:i') }} ({{ $register->updated_at?->diffForHumans(['short' => true]) }})</span>
        @endisset
	</div>


	<div class="space-y-4 mb-4">
		@foreach($read as $card)
			<x-element::card title="{{ $card->getTitle() }}" :padding=false class="bg-white">
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
								
								@if($component_name = $item->getComponentName())
									<x-dynamic-component :component="$component_name" :label=$item :register=$register />
								@else
									{{ $item->getContent($register) }}
								@endif
							</div>
						</div>
					@endforeach
				</div>
			</x-element::card>
		@endforeach
	</div>

	<div class="space-y-4 mb-4">
		@foreach($repeaters ?? [] as $repeater)
			<x-element::card class="bg-white" title="{{ $repeater->getTitle() }}" :padding=false>
				@livewire('table-repeater', [
					'register_id' => $register->id,
					'resource_slug' => $resource->getSlug(),
					'repeater_slug' => $repeater->getSlug()
				])
			</x-element::card>
		@endforeach
	</div>
@endsection
