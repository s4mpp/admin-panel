
<div class="space-y-4">	
	<x-element::message.error :provider=$errors />
	
	@dump($this->data)

	{{-- <div 
		x-data="{ {{ join(', ', array_merge($data_slides ?? [])) }} }"
		x-on:close-slide.window="{{ join(', ', $close_slides ?? []) }}"> --}}
		{{-- x-on:close-modal.window="{{ join(', ', $close_modals ?? []) }}"> --}}
		<form wire:submit.prevent="save" class="mb-0" x-data="{loading: false}" x-on:submit="loading = true" x-on:reset-loading.window="loading = false">
			<div class="space-y-4 mb-4">
				@foreach($this->form ?? [] as $element)
					{{ $element->render() }}
				@endforeach
			</div>

			@isset($repeaters)
				<div class="space-y-4 mb-4">
					@foreach($repeaters ?? [] as $key => $repeater)
						<x-element::card title="{{ $repeater->getTitle() }}" class="bg-white" :padding=false>

							{{-- @if($repeater->canAdd()) --}}
								<x-slot:header class=" flex justify-end">
									<x-element::button type="button"
										x-on:click="$wire.emit('setRegister:{{ $repeater->getRelation() }}', null, null, {}), slide{{ $repeater->getRelation() }} = true"
										:loading=false>Adicionar</x-element::button>
								</x-slot:header>
							{{-- @endif --}}

							@php
								$columns = $repeater->getColumns();

								$registers = $this->repeater_tables[$repeater->getRelation()] ?? null;
							@endphp

							<x-element::table>
								<x-slot:header>
									@foreach($columns as $column)
										<x-element::table.th @class([
											'text-left' => ($column->getAlignment() == 'left'),
											'text-center' => ($column->getAlignment() == 'center'),
											'text-right' => ($column->getAlignment() == 'right'),
										])>{{ $column->getTitle() }}</x-element::table.th>
									@endforeach
								</x-slot:header>

								<x-slot:body>
									@foreach($registers ?? [] as $key => $register)
										<tr>
											@foreach ($columns as $column)
												<x-element::table.td
													@class([
														'text-left' => ($column->getAlignment() == 'left'),
														'text-center' => ($column->getAlignment() == 'center'),
														'text-right' => ($column->getAlignment() == 'right'),
														'font-semibold text-gray-900' => $column->getIsStrong()
													])>

													@if($component_name = $column->getComponentName())
														<x-dynamic-component :component="$component_name" :label=$column :register=$register />
													@else
														{{ $column->getContent($register) }}
													@endif
												</x-element::table.td>
											@endforeach

											<x-element::table.td class="flex justify-end">
												<div class="inline-flex gap-3 font-medium text-right ">
													<button
														type="button"
														x-on:click="$wire.emit(
															'setRegister:{{ $repeater->getRelation() }}',
															{{ $register['id_temp'] }}, 
															{{ $register['id'] ?? 'null' }},
															@js($register)
														), 
														slide{{ $repeater->getRelation() }} = true"
														class="text-gray-500 hover:text-gray-600 inline-flex gap-1">
														<span>Editar</span>
													</button>
												</div>
											</x-element::table.td>
										</tr>
									@endforeach
								</x-slot:body>

							</x-element::table>
						</x-element::card>
					@endforeach
				</div>
			@endisset

			<div class="sm:px-0">
				<x-element::button loading type="submit">Salvar</x-element::button>
			</div>
		</form>

		
		
		{{-- @foreach($search_fields ?? [] as $search)
			<x-modal title="Selecionar {{ Str::lower($search->getTitle()) }}" idModal="modal{{ $search->getName() }}">
				@livewire('select-search', [
					'model' => $search->getModelName(),
					'field_to_search' => $search->getModelField(),
					'field_to_update' => $search->getName(),
					'repeater' => $search->getRepeater(),
				], key($search->getName()))
			</x-modal>
		@endforeach --}}
	{{-- </div> --}}
</div>

