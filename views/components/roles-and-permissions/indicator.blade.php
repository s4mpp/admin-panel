<div class="items-center flex bg-gray-200 rounded-md text-sm ">
	<div class=" flex justify-start items-center pr-2 pl-3 py-1 gap-2 text-gray-600">
		<span>{{ $attributes['title'] ?? '' }}</span>

		<div class="flex border-l border-gray-300 pl-2 items-center justify-normal ">
			<x-element::icon class="h-3 w-3 mt-0.5" mini name="users" /><span> {{ $attributes['total_users'] ?? 0 }}</span>
		</div>
	</div>

	@isset($actions)
		<x-element::dropdown>
			<x-slot:button class="flex items-center pr-2">
				<button x-on:click="dropdown = !dropdown" class="h-4 w-4 bg-gray-300 hover:bg-gray-400/70 focus:bg-gray-400 focus:text-white hover:text-white transition-colors flex items-center justify-center rounded-full"><x-element::icon class="h-4 w-4" name="chevron-down" solid mini /></button>
			</x-slot:button>

			<x-slot:body>
				{{ $actions }}
			</x-slot:body>
		</x-element::dropdown>
	@endisset

</div>