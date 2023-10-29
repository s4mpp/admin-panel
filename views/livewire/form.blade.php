<div>

	@php
		$data_slides = $close_slides = [];
		foreach($repeaters as $repeater)
		{
			$data_slides[] = 'slide'.$repeater->getRelation().': false';
			$close_slides[] = 'slide'.$repeater->getRelation().' = false';
		}
	@endphp

	<x-alert />

	<div 
		x-data="{ {{ join(',', $data_slides) }} }"
		x-on:close-slide.window="{{ join(',', $close_slides) }}" >
		<form wire:submit.prevent="save" class="mb-0" x-data="{loading: false}" x-on:submit="loading = true" x-on:reset-form.window="loading = false">
			
			<div class="overflow-hidden sm:rounded-lg bg-white border-t border-b sm:border-l sm:border-r  mb-6">
				@foreach($this->form ?? [] as $element)
					{{ $element->render($register ?? null) }}
				@endforeach
			</div>

			@foreach($repeaters as $repeater)
				<x-card title="{{ $repeater->getTitle() }}" className="bg-white border mb-6" :padding=false>
					<x-slot:header class=" flex justify-end">
						<x-button x-on:click="slide{{ $repeater->getRelation() }} = true; $wire.set('child_id', [])" type="button">Adicionar</x-button>
					</x-slot:header>
					
					<div class="overflow-x-auto mb-2">
						<table class="min-w-full divide-y divide-gray-100">
							<thead class="bg-gray-100 rounded">
								<tr>
									<th scope="col" class="px-4 sm:px-6 py-3.5 text-left text-sm font-semibold text-gray-800  whitespace-nowrap  ">Seq.</th>
									@foreach($repeater->getFields() as $field)
										<th scope="col" class="px-4 sm:px-6 py-3.5 text-left text-sm font-semibold text-gray-800 whitespace-nowrap">{{ $field->title }}</th>
									@endforeach
								</tr>
							</thead>
							<tbody class="divide-y divide-gray-200 bg-white">
								@if($this->childs[$repeater->getRelation()])
									@foreach($this->childs[$repeater->getRelation()] as $i => $item)
										<tr x-on:click="slide{{ $repeater->getRelation() }} = true" wire:click.prevent="setChild('{{ $repeater->getRelation() }}', {{ $i }})" class="cursor-pointer hover:bg-gray-50 transition-colors">
											<td class="whitespace-nowrap px-4 sm:px-6 py-3.5 text-sm text-gray-500">{{ $i }}</td>
											@foreach($repeater->getFields() as $field)
												<td class="whitespace-nowrap px-4 sm:px-6 py-3.5 text-sm text-gray-500">{{ $item[$field->name] ?? '' }}</td>
											@endforeach
										</tr>
									@endforeach
								@else
									<tr>
										<td colspan="2" class="text-center bg-white pt-12 pb-4 text-gray-500 text-sm">
											<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" class="mx-auto fill-gray-100 w-10 h-10 opacity-90">
												<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
											</svg>
											
											<span  class="text-sm mt-3 ">Nenhum registro</span>
										</td>
									</tr>
								@endif
							</tbody>
						</table>
					</div>
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

		@foreach($repeaters as $repeater)

			<x-slide-over id="slide{{ $repeater->getRelation() }}" title="{{ $repeater->getTitle() }}">
				<form wire:submit.prevent="saveChild('{{ $repeater->getRelation() }}')" x-data="{loading: false}" x-on:submit="loading = true" x-on:reset-form.window="loading = false">
		
					@foreach($repeater->getFields() as $element)
						<div>
							<div class="text-sm mb-2 font-medium text-slate-900">
								<p class="">
									{{ $element->title }}
						
									@if($element->isRequired())
										<span class="text-red-300 text-xs truncate">*</span>
									@endif
								</p>
						
							</div>
							{{ $element->setPrefix('child_data.'.$repeater->getRelation())->renderInput() }}
						</div>
					@endforeach
		
					<div class="px-4 border-t mt-4 pt-4 sm:px-0">
						<x-button type="submit" className="btn-primary">
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