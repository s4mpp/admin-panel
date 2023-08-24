@php
	$rowspan_empty = count($columns) ?? 1;

	if($actions)
	{
		$rowspan_empty++;
	}
@endphp

<x-card>
	<div class="overflow-x-auto ">
		<div class="min-w-full px-3 p-5">
			
		</div>

	<table class="min-w-full divide-y divide-slate-300">
		<thead class="bg-slate-50">
		  <tr>
			  @forelse($columns as $column)
				  <th scope="col" @class(array_merge($column->style_class, ['px-5 py-3.5 text-left text-sm font-semibold text-slate-900  whitespace-nowrap']))>{{ $column->title }}</th>
			  @empty
				  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-slate-900">&nbsp;</th>
			  @endforelse

			  @if($actions)
				  <th></th>
			  @endif
		  </tr>
		</thead>
		<tbody class="divide-y divide-slate-200 bg-white">
		  @if($registers)
			@foreach($registers as $id => $row)
				<tr class=" ">
					@forelse ($row as $field)
						<td @class(array_merge($field->style_class, ['whitespace-nowrap px-5 py-4 text-sm text-slate-500']))>
							@php
								$data = $field->data;
							@endphp
							@switch($field->type)
								@case('boolean')
									
									@if($data)
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="mx-auto w-5 h-5 fill-green-500">
										<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
									  </svg>
									@else
										<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" class="mx-auto w-5 h-5 fill-red-500">
											<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
										</svg>
									@endif
									@break
								
								@case('enum')
									<x-badge :provider=$data></x-badge>
									@break
								
								@case('dump')
									@dump($data)
									@break

								@default
									{{ $data }}
							@endswitch
						</td>
					@empty
						<td>&nbsp;</td>
					@endforelse 

					@if($actions)
						<td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
							<x-admin-actions local="table" :actions=$actions :actionRoutes=$actionRoutes :id=$id />
						</td>
					@endif
				</tr>
			@endforeach
		@else
			<tr>
				<td colspan="{{ $rowspan_empty }}" class="text-center pt-4 pb-4">Nenhum registro</td>
			</tr>
		@endif
	  </table>
	</div>

	<div class="min-w-full px-3  p-5">

		{{ $collection->links() }}
	</div>
</x-card>
