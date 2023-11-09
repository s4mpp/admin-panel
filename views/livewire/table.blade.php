@php
	$rowspan_empty = count($table) ?? 1;

	if($this->resource->actions)
	{
		$rowspan_empty++;
	}
	

@endphp

<div class="border lg:rounded-lg bg-white mx-0 sm:-mx-6 lg:mx-0" x-on:notify.window="$wire.emit('searchTable')"> 
	<div class="min-w-full px-2  py-2 flex justify-start">
		@if($has_search)
			<div class="w-full sm:w-6/12 md:w-5/12 xl:w-4/12 mr-3">
				<x-input placeholder="{{ $placeholder_field_search }}" wire:model.debounce.500ms="search" type="search" name="search">
					<x-slot:start>
						<div wire:loading wire:target="search">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class=" animate-spin w-5 h-5">
								<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
							</svg>
						</div>
						<div wire:loading.remove wire:target="search">
							<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
								<path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
							</svg>
						</div>
					</x-slot:start>
				</x-input>
			</div>
		@endif

		@if($this->filters_available)
			<div class="relative inline-block text-left" x-data="{openSlideFilter: false}" x-on:close-slide.window="openSlideFilter = false">
				<x-button type="button" className="btn-light" x-on:click="openSlideFilter = true">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
						<path stroke-linecap="round" stroke-linejoin="round" d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 01-.659 1.591l-5.432 5.432a2.25 2.25 0 00-.659 1.591v2.927a2.25 2.25 0 01-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 00-.659-1.591L3.659 7.409A2.25 2.25 0 013 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0112 3z" />
					</svg>
					@if($this->filters)
						<span class="absolute justify-center flex items-center right-0 top-0 h-4 w-4 -translate-y-1/2 translate-x-1/2 transform rounded-full bg-orange-300 ring-2 ring-white">
							<span class="text-[12px] text-white">{{ count($this->filters) }}</span>
						</span>
					@endif
				</x-button>

				<x-slide-over id="openSlideFilter" title="Filtros">
					<form wire:submit.prevent="setFilter" x-data="{loading: false}" x-on:submit="loading = true" x-on:reset-form.window="loading = false">
						<div class="divide-y divide-gray-100">
							@foreach($this->filters_available as $filter)
								@php $i=0; @endphp
								<div class="py-4">
									 
									@if($filter->getType() == 'enum')
										{{-- <x-input type="checkbox" title="{{ $filter->title }}" name="{{ $filter->field }}[]">
											@foreach($filter->getOptions() as $option)
												<x-check 
												wire:model.defer="filters.{{ $filter->field }}.values.{{ $i++ }}" value="{{ $option['id'] }}">{{ $option['label'] }}</x-check>
											@endforeach
										</x-input> --}}
									@elseif($filter->getType() == 'period')
										<div class="flex justify-between align-end">
											<div class="flex-fill">
												<x-input type="date" wire:model.defer="filters.{{ $filter->field }}.start" name="start" title="Data inicial" />
											</div>
											<span class="text-base text-gray-700 w-12 text-center pb-2 justify-end flex flex-col">até</span>
											<div class="flex-fill">
												<x-input type="date" wire:model.defer="filters.{{ $filter->field }}.end" name="end" title="Data final" />
											</div>
										</div>
									@endif
								</div>
							@endforeach
						</div>

						<div class="mt-3 flex justify-between items-center border-t pt-3">
							<a href="#" wire:click.prevent="resetFilter" class="text-red-500 text-sm font-semibold">Limpar</a>
							<x-button className="btn-primary">Aplicar</x-button>
						</div>
					</form>
				</x-slide-over>
			</div>
		@endif
	</div>

	@if($this->filters)
 		<div class="min-w-full px-4 sm:px-6 py-2 flex justify-between items-center bg-gray-50 border-t">
			<div>
				<span class="text-sm font-semibold text-gray-600 mr-3">Filtros: </span>

				@foreach($this->filters as $field => $filter)
					<span class="inline-flex items-center gap-x-0.5 rounded-md bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">
						{{ $filter['title'] }}
						<button wire:click.prevent="removeFilter('{{ $field }}')" type="button" class="group relative -mr-1 h-3.5 w-3.5 rounded-sm hover:bg-yellow-600/20">
							<span class="sr-only">Remove</span>
								<svg viewBox="0 0 14 14" class="h-3.5 w-3.5 stroke-yellow-700/50 group-hover:stroke-yellow-700/75" >
									<path d="M4 4l6 6m0-6l-6 6" />
								</svg>
							<span class="absolute -inset-1"></span>
						</button>
					</span>
				@endforeach
			</div>
				
			<a href="#" wire:click.prevent="resetFilter" class="text-gray-500">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
					<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
				</svg>
			</a>
		</div>
	@endif

	<div class="overflow-x-auto mb-2">
		<table class="min-w-full divide-y border-t divide-gray-100">
		<thead class="bg-gray-100 rounded">
		  <tr>
			  @forelse($table as $column)
				  <th scope="col" @class([
					'text-center' => (($column->getAlignment() ?? null) == 'center'),
					'text-right' => (($column->getAlignment() ?? null) == 'right'),
					'px-4 sm:px-6 py-3.5 text-left text-sm font-semibold text-gray-800  whitespace-nowrap'])>{{ $column->getTitle() }}</th>
			  @empty
				  <th scope="col" class="px-3 py-3.5">&nbsp;</th>
			  @endforelse

			  @if($this->resource->actions)
				<th></th>
			@endif
		  </tr>
		</thead>
		<tbody class="divide-y divide-gray-200 bg-white">
			@if($registers)
				@foreach($registers as $id => $row)
					<tr class="group">
						@forelse ($row['registers'] as $field)
							<td 
							@if($default_action)
								x-on:click="window.location.href = '{{ route($default_action, ['id' => $id])  }}'"
							@endif
							@class([
								'text-center' => (($field->getAlignment() ?? null) == 'center'),
								'text-right' => (($field->getAlignment() ?? null) == 'right'),
								
								'font-semibold text-gray-900' => $field->strong ?? false,
								'cursor-pointer group-hover:bg-gray-50/90 transition peer' => $default_action,
								'whitespace-nowrap px-4 sm:px-6 py-3.5 text-sm text-gray-500'
							])>
								@php
									$data = $field->data;
								@endphp
								@switch($field->getType())
									@case('boolean')

									
										@if($data)
											<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="mx-auto w-5 h-5 fill-green-500">
												<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
											</svg>
										@else
											<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="mx-auto w-5 h-5 fill-red-500">
												<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
											</svg>
										@endif
									
										
										@break
									
									@case('enum')
										<x-badge :provider=$data></x-badge>
										@break

									@case('datetime')
										{{ $data?->format($field->getAdditionalData('format')) }}
										@if($data)
											<span class="opacity-50">({{ $data?->diffForHumans() }})</span>
										@endif
										@break
									
									@case('dump')
										@dump($data)
										@break

									@default
										{{ $data }}
								@endswitch
							</td>
						@empty
							<td>&nbsp;</td>
						@endforelse 

						@if($this->resource->actions)
							<td
							@class([
								'hover:bg-gray-50/90 peer-hover:bg-gray-50/90 transition-colors' => $default_action,
								'whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6'
							])>
								<div class="inline-flex gap-3">
									@if(in_array('read', $this->resource->actions))
										<a	href="{{ route($this->resource->getRouteName('read'), ['id' => $id]) }}" class="text-gray-500 hover:text-gray-600 inline-flex gap-1">
											<span>Visualizar</span>
										</a>
									@endif
									
									@if(in_array('update', $this->resource->actions))
										<a	href="{{ route($this->resource->getRouteName('update'), ['id' => $id]) }}" class="text-gray-500 hover:text-gray-600 inline-flex gap-1">
											<span>Editar</span>
										</a>
									@endif

									@if(in_array('delete', $this->resource->actions))
										<form onsubmit="return window.confirm('Tem certeza que deseja excluir este registro?')" method="POST"  action="{{ route($this->resource->getRouteName('delete'), ['id' => $id]) }}">
												@method('DELETE')
												@csrf
											
											 <button class="text-red-500 hover:text-red-600 inline-flex gap-1" type="submit">Excluir</button>
										</form>
									@endif
								</div>
							</td>
						@endif
					</tr>
				@endforeach
			@else
				<tr>
					<td colspan="{{ $rowspan_empty }}" class="text-center bg-white pt-12 pb-4 text-gray-500 text-sm">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" class="mx-auto fill-gray-100 w-10 h-10 opacity-90">
							<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
						</svg>
						
						<span  class="text-sm mt-3 ">{{ $this->search ? 'Nada encontrado' : 'Nenhum registro' }}</span>
					</td>
				</tr>
			@endif
        </tbody>
	  </table>
	</div>

	@if($collection->count() > 0)
		@if($collection->hasPages())
			<div class="flex-auto px-3">
				{{ $collection->links('admin::pagination') }}
			</div>
		@endif
		
		<p class="text-center border-t pt-3 text-xs mb-3 text-gray-700">{{ $collection->total() }} {{ Str::plural('registro', $collection->total()) }}</p>
	@endif
</div>