 <div
 	x-data x-on:search.window="$wire.emit('search', {q: $event.detail.q})"
 	x-on:filter.window="$wire.emit('filter', {filters: $event.detail.filters}), console.log($event.detail.filters)"
	{{-- x-on:reset-filter.window="$wire.set('filter_term', null), $wire.set('filter_descriptions', [])"
	x-on:search.window="$wire.emit('searchTable', {q: $event.detail.q})"
	x-on:filter.window="$wire.emit('filterTable', {filters: $event.detail.filters})" --}}
	>
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

		@if(!$registers->isEmpty())
			<x-slot:body>
				@foreach($registers ?? [] as $register)
					<tr>
						@if($columns)
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
									@if(array_key_exists('read', $route_actions))
										<a	href="{{ route($route_actions['read'], ['id' => $register->id]) }}" class="text-gray-500 hover:text-gray-600 inline-flex gap-1">
											<span>Visualizar</span>
										</a>
									@endif
									
									@if(array_key_exists('update', $route_actions))
										<a	href="{{ route($route_actions['update'], ['id' => $register->id]) }}" class="text-gray-500 hover:text-gray-600 inline-flex gap-1">
											<span>Editar</span>
										</a>
									@endif
								
									@if(array_key_exists('delete', $route_actions))
										<form onsubmit="return window.confirm('Tem certeza que deseja excluir este registro?')" method="POST"  action="{{ route($route_actions['delete'], ['id' => $register->id]) }}">
											@method('DELETE')
											@csrf
											
											<button class="text-red-500 hover:text-red-600 inline-flex gap-1" type="submit">Excluir</button>
										</form>
									@endif
								</div>
							</x-element::table.td>
						@else
							<x-element::table.td>&nbsp;</x-element::table.td>
						@endif

					</tr>
				@endforeach
			</x-slot:body>
		@endif
	</x-element::table>

	@if(!$registers->isEmpty())

		<p class="text-center border-t  py-3 text-xs mb-0 text-gray-700">{{ $registers->total() }} {{ Str::plural('registro', $registers->total()) }}</p>
		
		{{ $registers->links('admin::pagination', ['numbers' => true]) }}
	@endif
</div>