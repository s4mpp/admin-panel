<div 
	x-data="{loading: false, items: []}"
	x-on:submit="loading = true"
	x-on:reset-loading.window="loading = false">
	<x-card title="{{ $title }}" className="bg-white border mb-6">

		<x-alert/>
	
		<div x-data="{loading:false}" x-on:reset-loading.window="loading = false">
			<div class="my-3">
				@foreach($fields as $field)
					{{ $field->render(['x-model' => $field->name]) }}
				@endforeach
			</div>
			
			<x-button x-on:click="loading = true" type="button" x-on:click="items.push({name: 'a'})">Adicionar</x-button>
		</div>

		<div class="overflow-x-auto mb-2">
			<table class="min-w-full divide-y border-t divide-gray-100">
				<thead class="bg-gray-100 rounded">
					<tr>
						<th scope="col" class="px-4 sm:px-6 py-3.5 text-left text-sm font-semibold text-gray-800  whitespace-nowrap  ">ID</th>
						@foreach($fields as $field)
							<th scope="col" class="px-4 sm:px-6 py-3.5 text-left text-sm font-semibold text-gray-800 whitespace-nowrap">{{ $field->title }}</th>
						@endforeach
					</tr>
				</thead>
				<tbody class="divide-y divide-gray-200 bg-white">
					<template x-for="(item, index) in items">
						<tr class="group">
						<td class="whitespace-nowrap px-4 sm:px-6 py-3.5 text-sm text-gray-500" x-text="index"></td>
							<td class="whitespace-nowrap px-4 sm:px-6 py-3.5 text-sm text-gray-500" x-text="item.name"></td>
						</tr>
					</template>
				</tbody>
		  </table>
		</div>
	</x-card>
</div>