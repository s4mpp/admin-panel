<div x-data="{searching: false}">
	<x-element::form.input {{ $attributes }} 
		x-on:keydown.enter.prevent.stop=""
		x-on:search-complete.window="searching = false"
		type="search">
		<x-slot:start class="w-[25px] text-gray-500">
			<div x-show="searching" x-cloak>
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class=" animate-spin w-5 h-5">
					<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
				</svg>
			</div>
			<div x-show="!searching" x-cloak>
				<x-element::icon name="magnifying-glass" class=" w-5 h-5" />
			</div>
		</x-slot:start>
	</x-element::form.input>
</div>