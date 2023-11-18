<div>
	<x-alert />

	<div 
		x-data="{ {{ join(',', $data_slides) }} }"
		x-on:close-slide.window="{{ join(',', $close_slides) }}">
		<form wire:submit.prevent="save" class="mb-0" x-data="{loading: false}" x-on:submit="loading = true" x-on:reset-form.window="loading = false">
 			<div class="space-y-4 mb-4">
				@foreach($this->form ?? [] as $element)
					{{ $element->render($register ?? null) }}
				@endforeach
			</div>

			@foreach($repeaters ?? [] as $repeater)
				<x-card title="{{ $repeater->getTitle() }}" className="bg-white border mb-6" :padding=false>
					<x-slot:header class=" flex justify-end">
						<x-button :loading=false x-on:click="slide{{ $repeater->getRelation() }} = true; $wire.set('current_child_id', []), $wire.set('current_child_data', [])" type="button">Adicionar</x-button>
					</x-slot:header>

					@php
						$columns = $repeater->getColumns();

						$registers = $this->childs[$repeater->getRelation()];
					@endphp

					<x-table :columns=$columns :registers=$registers></x-table>
				</x-card>
			@endforeach

			<div class="px-4 sm:px-0">
				<x-button type="submit" className="btn-primary">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
						<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
					</svg>
					
					<span>Salvar</span>
				</x-button>
			</div>
		</form>

		@foreach($repeaters ?? [] as $repeater)

			<x-slide-over id="slide{{ $repeater->getRelation() }}" title="{{ $repeater->getTitle() }}">
				<form wire:submit.prevent="saveChild('{{ $repeater->getRelation() }}')" x-data="{loading: false}" x-on:submit="loading = true" x-on:reset-form.window="loading = false">
		
					@foreach($repeater->getFields() as $element)
						<div>
							<div class="text-sm mb-2 font-medium text-slate-900">
								<p class="">
									{{ $element->getTitle() }}
						
									@if($element->isRequired())
										<span class="text-red-300 text-xs truncate">*</span>
									@endif
								</p>
						
							</div>
							{{ $element->setPrefix('current_child_data.'.$repeater->getRelation())->renderInput() }}
						</div>
					@endforeach
		
					<div class="px-4 border-t mt-4 pt-4 sm:px-0">
						<x-button  type="submit" className="btn-primary">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
								<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
							</svg>
							
							<span>Concluir</span>
						</x-button>
					</div>
				</form>
			</x-slide-over>
		@endforeach
	</div>
</div>