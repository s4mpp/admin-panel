<div x-data x-on:search.window="$wire.emit($event.detail.e, {q: $event.detail.q})"> 
	@if(!$search_term)
		<div class="text-center text-sm p-4 rounded-lg mt-3 bg-gray-100 text-gray-600 w-full">
			<p>Digite algo no campo acima para pesquisar.</p>
		</div>
	@elseif($search_term && $total_registers == 0)
		<div class="text-center text-sm p-4 rounded-lg mt-3 bg-gray-100 text-gray-600 w-full">
			<p>Nenhum resultado encontrado com o termo <strong>"{{ $this->search_term }}"</strong>.</p>
		</div>
	@else
		<p class="text-sm text-gray-500 mt-3">{{ $total_registers }} {{ Str::of('resultado')->plural($total_registers) }}  {{ Str::of('encontrado')->plural($total_registers)  }}:</p>

		<div class="space-y-2 mt-2" x-data="{loadingSearch: false}" x-on:reset-loading.window="loadingSearch = false">
			@foreach($registers ?? [] as $register)
				<div class="rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 hover:cursor-pointer p-3 flex justify-between items-center transition-colors"
				x-on:click="$dispatch('set-search-input', {'id': {{ $register->id }}, 'name': '{{ $register->{$this->field_to_search} }}'}); $dispatch('close-modal-search')">
					
					<span class="text-sm">{{ $register->{$this->field_to_search} }}</span>
				</div>
			@endforeach

			@if($registers)
				<div class="flex-auto ">
					{{ $registers->links('admin::pagination', ['numbers' => false]) }}
				</div>
			@endif
		</div>
	@endif
</div>