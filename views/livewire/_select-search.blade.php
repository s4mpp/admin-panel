<div>
	<form class="w-full" wire:submit.prevent="search">
		<x-input wire:model.defer="search_term" placeholder="Pesquisar..." type="search">
			<x-slot:start>
				<div>
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
						<path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
					</svg>
				</div>
			</x-slot:start>
		</x-input>
	</form>

	<div class="text-base p-4 rounded-lg mt-3 bg-gray-100 text-gray-600 w-full flex justify-center gap-4 items-center" wire:loading.flex wire:target="search">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class=" animate-spin w-4 h-4">
			<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
		</svg>
		<p>Pesquisando...</p>
	</div>

	<div>
		@if(!$search_term)
			<div class="text-center text-sm p-4 rounded-lg mt-3 bg-gray-100 text-gray-600 w-full">
				<p>Digite algo no campo acima e pressione <strong>Enter</strong> para pesquisar.</p>
			</div>
		@elseif($search_term && $total_registers == 0)
			<div class="text-center text-sm p-4 rounded-lg mt-3 bg-gray-100 text-gray-600 w-full">
				<p>Nenhum resultado encontrado com o termo <strong>"{{ $this->search_term }}"</strong>.</p>
			</div>
		@else
			<p class="text-sm text-gray-500 mt-3">{{ $total_registers }} {{ Str::of('resultado')->plural($total_registers) }}  {{ Str::of('encontrado')->plural($total_registers)  }}:</p>

			<div class="space-y-2 mt-2" x-data="{loadingSearch: false}" x-on:reset-loading.window="loadingSearch = false">
				@foreach($collection as $register)
					<div x-data="{loadingThis: false}" x-on:reset-loading.window="loadingThis = false"
						:class="(loadingThis) ? 'bg-gray-200' : ''"
						class="rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors text-gray-700 hover:cursor-pointer p-3 flex justify-between items-center"
						x-on:click="(loadingSearch) ? null : ($wire.emitUp('setField', '{{ $this->repeater ?? 'null' }}', '{{ $this->field_to_update }}', {{ $register->id }}), loadingSearch = true, loadingThis = true)">
						
						<span class="text-sm">{{ $register->{$this->field_to_search} }}</span>

						<div x-cloak x-show="loadingThis">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class=" animate-spin w-4 h-4">
								<path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
							</svg>
						</div>
					</div>
				@endforeach
 
				<div class="flex-auto px-3">
					{{ $collection->links('admin::pagination', ['numbers' => false]) }}
				</div>
			</div>
		@endif
	</div>
</div>