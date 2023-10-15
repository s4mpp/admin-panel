<div>
	<x-card title="Produtos" className="bg-white border mb-6">
		
		<div x-data="{loading:false}" x-on:reset-loading.window="loading = false">
			<div class="my-3">
				<x-input type="text" title="Titulo" name="title" wire:model.defer="item.title"></x-input>
			</div>
			
			<x-button x-on:click="loading = true" type="button" wire:click="addItem">Adicionar</x-button>
		</div>

		<div class="overflow-x-auto mb-2">
			<table class="min-w-full divide-y border-t divide-gray-100">
				<thead class="bg-gray-100 rounded">
					<tr>
						<th scope="col" class="px-4 sm:px-6 py-3.5 text-left text-sm font-semibold text-gray-800  whitespace-nowrap  ">ID</th>
						<th scope="col" class="px-4 sm:px-6 py-3.5 text-left text-sm font-semibold text-gray-800  whitespace-nowrap  ">Titulo</th>
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-200 bg-white">
					@if($this->items)
						@foreach($this->items as $i => $item)
							<tr class="group">
								<td>{{ $i }}</td>
								<td class="whitespace-nowrap px-4 sm:px-6 py-3.5 text-sm text-gray-500">{{ $item['title'] ?? '' }}</td>
							</tr>
						@endforeach
					@else
						<tr>
							<td colspan="2" class="text-center bg-white pt-12 pb-4 text-gray-500 text-sm">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" class="mx-auto fill-gray-100 w-10 h-10 opacity-90">
									<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
								</svg>
								
								<span  class="text-sm mt-3 ">Nenhum registro</span>
							</td>
						</tr>
					@endif
				</tbody>
		  </table>
		</div>
	</x-card>
</div>