<x-element::form.input {{ $attributes }} x-data="{searching: false}" x-on:search-complete.window="searching = false" type="search" x-on:keyup.debounce="$dispatch('search', {q: $event.target.value}), searching = true">
	{{-- <x-slot:start>
		<div x-show="searching" x-cloak>
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class=" animate-spin w-5 h-5">
				<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
			</svg>
		</div>
		<div x-show="!searching" x-cloak>
			<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
				<path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
			</svg>
		</div>
	</x-slot:start> --}}
</x-element::form.input>