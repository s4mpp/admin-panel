<table class="min-w-full divide-y border-t divide-gray-100">
	<thead class="bg-gray-100 rounded">
		<tr>
			@foreach($labels as $label)
				<th scope="col" @class([
				'text-left' => ($label->getAlignment() == 'left'),
				'text-center' => ($label->getAlignment() == 'center'),
				'text-right' => ($label->getAlignment() == 'right'),
				'px-4 sm:px-6 py-3.5 text-left text-sm font-semibold text-gray-800  whitespace-nowrap'])>{{ $label->getTitle() }}</th>
			@endforeach
		</tr>
	</thead>
	<tbody class="divide-y divide-gray-200 bg-white">
		@if($rows)
			@foreach($rows as $i => $row)
				<tr class="group">
					@forelse ($row as $cell)
						<td
							@class([
								'text-left' => ($cell->getLabel()->getAlignment() == 'left'),
								'text-center' => ($cell->getLabel()->getAlignment() == 'center'),
								'text-right' => ($cell->getLabel()->getAlignment() == 'right'),
								'font-semibold text-gray-900' => $cell->getLabel()->getIsStrong(),
								'whitespace-nowrap px-4 sm:px-6 py-3.5 text-sm text-gray-500'
							])>

							{{ $cell->getLabel()->showContent($cell->getValue()) }}
						</td>
					@empty
						<td class="whitespace-nowrap px-4 sm:px-6 py-3.5 text-sm text-gray-500">&nbsp;</td>
					@endforelse
				</tr>
			@endforeach
		@else
			<tr>
				<td colspan="{{ $rowspan_empty }}" class="text-center bg-white pt-12 pb-4 text-gray-500 text-sm">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor" class="mx-auto fill-gray-100 w-10 h-10 opacity-90">
						<path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
					</svg>
					
					<span  class="text-sm mt-3 ">Nenhum registro</span>
				</td>
			</tr>
		@endif
	</tbody>
</table>
 