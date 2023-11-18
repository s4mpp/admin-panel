@foreach ($custom_actions as $action)

	@continue($action->isDisabled())

	@php
		if(method_exists($action, 'getNameSlide'))
		{
			$data_slides[] = $action->getNameSlide().': false';
		}
		elseif(method_exists($action, 'getNameModal'))
		{
			$data_modals[] = $action->getNameModal().': false';
		}

		if($action->hasConfirmation())
		{
			$data_modals[] = $action->getNameModalConfirmation().': false';
		}
	@endphp
@endforeach

<div x-data="{ {{ join(',', array_merge($data_modals ?? [], $data_slides ?? [])) }} }">

	@foreach ($custom_actions as $action)

		@continue($action->isDisabled())

		@if($action->hasConfirmation())
			@php
				$is_danger = $action->isDangerous()
			@endphp
			<x-modal 
				:danger=$is_danger
				title="{{ $action->getTitle() }}"
				subtitle="{{ $action->getMessageConfirmation() }}"
				idModal="{{ $action->getNameModalConfirmation() }}">

				{{ $action->renderContentModalConfirmation() }}
			</x-modal>
		@endif

		@if(method_exists($action, 'renderContent'))
			{{ $action->renderContent() }}
		@endif
	@endforeach

	<div class="inline-flex mr-3">
		<div class="relative  inline-block text-left" x-data="{dropdownCustomActions : false}">
			<x-button type="button" className="btn-secondary" x-on:click="dropdownCustomActions = !dropdownCustomActions">
				<span>Ações</span> <x-icon class=" w-5 h-5 mt-0.5" name="chevron-down" solid mini />			
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

						@foreach ($custom_actions as $action)

							@if($action->isDisabled())
								{{ $action->renderButtonDisabled() }}

								@continue
							@endif

							@if($action->hasConfirmation())
								{{ $action->renderButtonWithConfirmation() }}
							@else
								{{ $action->renderButton() }}
							@endif
						@endforeach
					</div>
			</div>
		</div>
	</div>
</div>

