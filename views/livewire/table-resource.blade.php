<x-element::card :padding=false className="bg-white"
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

								{{ $column->showContent($register->{$column->getField()}) }}
							</x-element::table.td>
						@endforeach
						
						<x-element::table.td>
							<div class="inline-flex gap-3 font-medium text-right ">
								 @if(array_key_exists('read', $actions))
									<a	href="{{ route($actions['read'], ['id' => $register->id]) }}" class="text-gray-500 hover:text-gray-600 inline-flex gap-1">
										<span>Visualizar</span>
									</a>
								@endif
								
								@if(array_key_exists('update', $actions))
									<a	href="{{ route($actions['update'], ['id' => $register->id]) }}" class="text-gray-500 hover:text-gray-600 inline-flex gap-1">
										<span>Editar</span>
									</a>
								@endif
							
								@if(array_key_exists('delete', $actions))
									<form onsubmit="return window.confirm('Tem certeza que deseja excluir este registro?')" method="POST"  action="{{ route($actions['delete'], ['id' => $register->id]) }}">
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
	</x-element::table>

	@if($registers)

		<p class="text-center border-t pt-3 text-xs mb-0 text-gray-700">{{ $registers->total() }} {{ Str::plural('registro', $registers->total()) }}</p>
		
		@if ($registers->hasPages())
			<nav class="flex items-center justify-between border-t mt-1 border-gray-200 px-4 sm:px-0">
				<div class="-mt-px flex w-0 flex-1">

				@if ($registers->onFirstPage())
						<span class="inline-flex items-center border-t-2 border-transparent pr-1 py-4 text-sm font-medium text-gray-500">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
								<path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
							</svg>

							Anterior
						</span>
					@else
						<button wire:click="previousPage('{{ $registers->getPageName() }}')" class="inline-flex   items-center border-t-2 border-transparent pr-1 py-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
								<path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
							</svg>

							Anterior
						</button>
					@endif
				</div>

				@if(isset($numbers) && $numbers)
					<div class="hidden md:-mt-px md:flex">
						@foreach ($elements as $element)
							@if (is_string($element))
								<span class="inline-flex   items-center border-t-2 border-transparent px-4 py-4 text-sm font-medium text-gray-500">...</span>
							@endif

							@if (is_array($element))
								@foreach ($element as $page => $url)
									@if ($page == $registers->currentPage())
										<span class="inline-flex   items-center border-t-2 border-indigo-500 px-4 py-4 text-sm font-medium text-indigo-600" aria-current="page">{{ $page }}</span>
									@else
										<button wire:click="gotoPage({{ $page }}, '{{ $registers->getPageName() }}')" class="inline-flex   items-center border-t-2 border-transparent px-4 py-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">{{ $page }}</button>
									@endif
								@endforeach
							@endif
						@endforeach
					</div>
				@endif
			
				<div class="-mt-px flex w-0 flex-1 justify-end">
					@if ($registers->hasMorePages())
						<button  wire:click="nextPage('{{ $registers->getPageName() }}')" class="inline-flex   items-center border-t-2 border-transparent pl-1 py-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
							Próxima
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
								<path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
							</svg>
							
						</button>
					@else
						<span class="inline-flex   items-center border-t-2 border-transparent pl-1 py-4 text-sm font-medium text-gray-500 ">
							Próxima
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
								<path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
							</svg>
						</span>
					@endif
				</div>
			</nav>
		@endif
	@endif
</x-element::card>

