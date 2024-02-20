<div>
	<table class="min-w-full divide-y border-t divide-gray-100">
		@if($collection->isNotEmpty())

			@isset($header)
				<thead class="bg-gray-100 rounded">
					<tr>
						{{ $header }}
					</tr>
				</thead>
			@endisset

			@isset($body)
				<tbody class="divide-y divide-gray-200 bg-white">
					{{ $body }}
				</tbody>
			@endisset
		@else
			<div class="text-center bg-white py-12   text-gray-500 text-sm">
				<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" class="mx-auto fill-gray-100 w-10 h-10 opacity-90">
					<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
				</svg>
				
				<span  class="text-sm mt-3 ">Nenhum registro</span>
			</div>
		@endif
	</table>

	
	<p class="text-center border-t pt-3 text-xs mb-0 text-gray-700">{{ $collection->total() }} {{ Str::plural('registro', $collection->total()) }}</p>
	
	@if ($collection->hasPages())
		<nav class="flex items-center justify-between border-t mt-1 border-gray-200 px-4 sm:px-0">
			<div class="-mt-px flex w-0 flex-1">

			@if ($collection->onFirstPage())
					<span class="inline-flex items-center border-t-2 border-transparent pr-1 py-4 text-sm font-medium text-gray-500">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
							<path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
						</svg>

						Anterior
					</span>
				@else
					<button wire:click="previousPage('{{ $collection->getPageName() }}')" class="inline-flex   items-center border-t-2 border-transparent pr-1 py-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
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
								@if ($page == $collection->currentPage())
									<span class="inline-flex   items-center border-t-2 border-indigo-500 px-4 py-4 text-sm font-medium text-indigo-600" aria-current="page">{{ $page }}</span>
								@else
									<button wire:click="gotoPage({{ $page }}, '{{ $collection->getPageName() }}')" class="inline-flex   items-center border-t-2 border-transparent px-4 py-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">{{ $page }}</button>
								@endif
							@endforeach
						@endif
					@endforeach
				</div>
			@endif
		
			<div class="-mt-px flex w-0 flex-1 justify-end">
				@if ($collection->hasMorePages())
					<button  wire:click="nextPage('{{ $collection->getPageName() }}')" class="inline-flex   items-center border-t-2 border-transparent pl-1 py-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
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
</div>