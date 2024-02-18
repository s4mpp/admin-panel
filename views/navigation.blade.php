<nav class="flex flex-1 flex-col">
	@foreach ($menu as $menu_item)
	
	{{-- <div class="text-xs font-semibold leading-6 text-uppercase text-gray-400">xxx</div> --}}
	
		<ul role="list" class="-mx-2 mt-2 space-y-1">
			<li>
				<a 
				@class([
					'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition-ease-in transition-colors ',
					'hover:bg-gray-100 text-gray-600 hover:text-primary' => !$menu_item->isActive(),
					'text-white  bg-gray-500 bg-primary' => $menu_item->isActive(),
				])
				href="{{ $menu_item->getAction() }}">
					<svg @class([
						'h-6 w-6 shrink-0 transition-colors',
						'text-gray-400 group-hover:text-primary' => !$menu_item->isActive(),
						'text-white' => $menu_item->isActive()

					]) fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
						<path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
					</svg>
				
					<span class="truncate">{{ $menu_item->getTitle() }}</span>
				</a>
			</li>
		</ul>
	@endforeach
</nav>