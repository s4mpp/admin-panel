@if ($paginator->hasPages())
	<nav class="flex items-center justify-between border-t   border-gray-200 px-4 sm:px-0">
		<div class="-mt-px flex w-0 flex-1">

		@if ($paginator->onFirstPage())
				<span class="inline-flex items-center border-t-2 border-transparent  py-4 px-3 text-sm font-medium text-gray-500">
					<x-element::icon name="chevron-left" class="w-5 h-5" />
					<span>Anterior</span>
				</span>
			@else
				<button wire:click="previousPage('{{ $paginator->getPageName() }}')" class="inline-flex    transition-colors items-center border-t-2 border-transparent py-4 px-3 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
					<x-element::icon name="chevron-left" class="w-5 h-5" />
					<span>Anterior</span>
				</button>
			@endif
		</div>

		@if(isset($numbers) && $numbers)

			<div class="hidden md:-mt-px md:flex">
				@foreach ($elements as $element)
					@if (is_string($element))
						<span class="inline-flex   transition-colors items-center border-t-2 border-transparent px-4 py-4 text-sm font-medium text-gray-500">...</span>
					@endif

					@if (is_array($element))
						@foreach ($element as $page => $url)
							@if ($page == $paginator->currentPage())
								<span class="inline-flex  transition-colors items-center border-t-2 border-gray-700 px-4 py-4 text-sm font-medium text-gray-900" aria-current="page">{{ $page }}</span>
							@else
								<button wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" class="inline-flex transition-colors  items-center border-t-2 border-transparent px-4 py-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">{{ $page }}</button>
							@endif
						@endforeach
					@endif
				@endforeach
			</div>
		@endif
	
		<div class="-mt-px flex w-0 flex-1 justify-end">
			@if ($paginator->hasMorePages())
				<button  wire:click="nextPage('{{ $paginator->getPageName() }}')" class="inline-flex   backdrop:  transition-colors items-center border-t-2 border-transparent px-3 py-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
					<span>Próxima</span>
					<x-element::icon name="chevron-right" class="w-5 h-5" />
					
				</button>
			@else
				<span class="inline-flex  items-center border-t-2 border-transparent px-3 py-4 text-sm font-medium text-gray-500 ">
					<span>Próxima</span>
					<x-element::icon name="chevron-right" class="w-5 h-5" />
				</span>
			@endif
		</div>
	</nav>
@endif