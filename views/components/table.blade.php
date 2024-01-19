<table class="min-w-full divide-y border-t divide-gray-100">
	<thead class="bg-gray-100 rounded">
		<tr>
			@forelse($columns as $column)
				<th scope="col" @class([
				'text-center' => (($column->getAlignment() ?? null) == 'center'),
				'text-right' => (($column->getAlignment() ?? null) == 'right'),
				'px-4 sm:px-6 py-3.5 text-left text-sm font-semibold text-gray-800  whitespace-nowrap'])>{{ $column->getTitle() }}</th>
			@empty
				<th scope="col" class="px-4 sm:px-6 py-3.5 text-left text-sm font-semibold text-gray-800  whitespace-nowrap">Tabela sem título</th>
			@endforelse
		</tr>
	</thead>
	<tbody class="divide-y divide-gray-200 bg-white">
		@if($registers)
			@foreach($registers as $i => $row)
				<tr class="group">
					@forelse ($row['registers'] as $field)
						<td 
						{{-- @if($default_route)
							x-on:click="window.location.href = '{{ route($default_route, ['id' => $id])  }}'"
						@endif --}}
						@class([
							'text-center' => (($field->getAlignment() ?? null) == 'center'),
							'text-right' => (($field->getAlignment() ?? null) == 'right'),
							
							'font-semibold text-gray-900' => $field->getIsStrong(),
							// 'cursor-pointer group-hover:bg-gray-50/90 transition peer' => $default_route,
							'whitespace-nowrap px-4 sm:px-6 py-3.5 text-sm text-gray-500'
						])>
							@php
								$data = $field->data;
							@endphp
							{{-- @switch($field->getType())
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
							@endswitch --}}

							@if(method_exists($field, 'render'))
								{{ $field->render($data, $i) }}
							@else
								{{ $data }}
							@endif
						</td>
					@empty
						<td class="whitespace-nowrap px-4 sm:px-6 py-3.5 text-sm text-gray-500">{{ $row['original'] }}</td>
					@endforelse 

					{{-- @if($this->resource->actions)
						<td
						@class([
							'hover:bg-gray-50/90 peer-hover:bg-gray-50/90 transition-colors' => $default_route,
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
					@endif --}}
				</tr>
			@endforeach
		@else
			<tr>
				<td colspan="{{ $rowspan_empty }}" class="text-center bg-white pt-12 pb-4 text-gray-500 text-sm">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" class="mx-auto fill-gray-100 w-10 h-10 opacity-90">
						<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
					</svg>
					
					<span  class="text-sm mt-3 ">Nenhum registro</span>
				</td>
			</tr>
		@endif
	</tbody>
</table>

@if((is_object($collection) && method_exists($collection, 'count') && $collection->count() > 0))
	@if(method_exists($collection, 'hasPages') && $collection->hasPages())
		<div class="flex-auto px-3">
			{{ $collection->links('admin::pagination', ['numbers' => true]) }}
		</div>
		
		<p class="text-center border-t pt-3 text-xs mb-3 text-gray-700">{{ $collection->total() }} {{ Str::plural('registro', $collection->total()) }}</p>
	@endif
@endif