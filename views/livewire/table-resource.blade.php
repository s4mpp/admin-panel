<x-element::card :padding=false className="bg-white"
	{{-- x-on:reset-filter.window="$wire.set('filter_term', null), $wire.set('filter_descriptions', [])"
	x-on:search.window="$wire.emit('searchTable', {q: $event.detail.q})"
	x-on:filter.window="$wire.emit('filterTable', {filters: $event.detail.filters})" --}}
	>

	<x-admin::table :collection=$registers>
		<x-slot:header>
			@foreach($columns as $column)
				<x-admin::table.th @class([
					'text-left' => ($column->getAlignment() == 'left'),
					'text-center' => ($column->getAlignment() == 'center'),
					'text-right' => ($column->getAlignment() == 'right'),
				])>{{ $column->getTitle() }}</x-admin::table.th>
			@endforeach
		</x-slot:header>

		<x-slot:body>
			@foreach($registers as $register)
				<tr>
					@forelse ($columns as $column)
						<x-admin::table.td
							@class([
								'text-left' => ($column->getAlignment() == 'left'),
								'text-center' => ($column->getAlignment() == 'center'),
								'text-right' => ($column->getAlignment() == 'right'),
								'font-semibold text-gray-900' => $column->getIsStrong()
							])>

							{{ $column->showContent($register->{$column->getField()}) }}
						</x-admin::table.td>
					@empty
						<x-admin::table.td>&nbsp;</x-admin::table.td>
					@endforelse
				</tr>
			@endforeach
		</x-slot:body>
	</x-admin::table>
</x-element::card>