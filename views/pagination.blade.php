@if ($paginator->hasPages())
<nav class="flex items-center justify-between border-t mt-4 border-gray-200 px-4 sm:px-0">
	<div class="-mt-px flex w-0 flex-1">

	  @if ($paginator->onFirstPage())
			<span class="inline-flex items-center border-t-2 border-transparent pr-1 py-4 text-sm font-medium text-gray-500">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
					<path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
				</svg>

				Anterior
			</span>
		@else
			<button wire:click="previousPage('{{ $paginator->getPageName() }}')" class="inline-flex   items-center border-t-2 border-transparent pr-1 py-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
					<path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
				</svg>

				Anterior
			</button>
		@endif
	</div>

	<div class="hidden md:-mt-px md:flex">
		@foreach ($elements as $element)
			@if (is_string($element))
				<span class="inline-flex   items-center border-t-2 border-transparent px-4 py-4 text-sm font-medium text-gray-500">...</span>
			@endif

			@if (is_array($element))
				@foreach ($element as $page => $url)
					@if ($page == $paginator->currentPage())
						<span class="inline-flex   items-center border-t-2 border-indigo-500 px-4 py-4 text-sm font-medium text-indigo-600" aria-current="page">{{ $page }}</span>
					@else
						<button wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" class="inline-flex   items-center border-t-2 border-transparent px-4 py-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">{{ $page }}</button>
					@endif
				@endforeach
			@endif
		@endforeach
	</div>
	
	<div class="-mt-px flex w-0 flex-1 justify-end">

		@if ($paginator->hasMorePages())
			<button  wire:click="nextPage('{{ $paginator->getPageName() }}')" class="inline-flex   items-center border-t-2 border-transparent pl-1 py-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
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