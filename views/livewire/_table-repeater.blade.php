<div>
	<x-element::table>
		<x-slot:header>
			@foreach($columns as $column)
				<x-element::table.th @class([
					'text-left' => ($column->getAlignment() == 'left'),
					'text-center' => ($column->getAlignment() == 'center'),
					'text-right' => ($column->getAlignment() == 'right'),
				])>{{ $column->getTitle() }}</x-element::table.th>
			@endforeach
		</x-slot:header>

		@if($registers && !$registers->isEmpty())
			<x-slot:body>
				@foreach($registers ?? [] as $register)
					<tr>
						@foreach ($columns as $column)
							<x-element::table.td
								@class([
									'text-left' => ($column->getAlignment() == 'left'),
									'text-center' => ($column->getAlignment() == 'center'),
									'text-right' => ($column->getAlignment() == 'right'),
									'font-semibold text-gray-900' => $column->getIsStrong()
								])>

								@if($component_name = $column->getComponentName())
									<x-dynamic-component :component="$component_name" :label=$column :register=$register />
								@else
									{{ $column->getContent($register) }}
								@endif
							</x-element::table.td>
						@endforeach
					</tr>
				@endforeach
			</x-slot:body>
		@endif
	</x-element::table>

	@if($registers && !$registers->isEmpty())

		<p class="text-center border-t  py-3 text-xs mb-0 text-gray-700">{{ $registers->total() }} {{ Str::plural('registro', $registers->total()) }}</p>
		
		{{ $registers->links('admin::pagination', ['numbers' => true]) }}
	@endif
</div>