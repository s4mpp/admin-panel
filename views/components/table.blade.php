@php
	$rowspan_empty = count($columns) ?? 1;

	if($actions)
	{
		$rowspan_empty++;
	}
@endphp

<div class="table-responsive">
	<table class="table bg-white table-sm">
		<thead>
			<tr>
				@if($actions)
					<th></th>
				@endif
				
				@forelse($columns as $column)
					<th @class(array_merge($column->style_class, ['text-nowrap']))>{{ $column->title }}</th>
				@empty
					<th>&nbsp;</th>
				@endforelse
			</tr>
		</thead>
		<tbody>
			@if($registers)
				@foreach($registers as $id => $row)
					<tr class="text-muted">

						@if($actions)
							<td class="d-flex justify-content-start gap-3">
								<x-admin-actions local="table" class="p-0" :actions=$actions :actionRoutes=$actionRoutes :id=$id />
							</td>
						@endif
						
						@forelse ($row as $field)
							<td @class(array_merge($field->style_class, ['text-nowrap']))>
								@php
									$data = $field->data;
								@endphp
								@switch($field->type)
									@case('boolean')
										@if($data)
											<i class="la la-check-circle text-success"></i>
										@else
											<i class="la la-times-circle text-danger"></i>
										@endif
										@break
									
									@case('enum')
										<x-badge :provider=$data></x-badge>
										@break

									@default
										{{ $field->data }}
								@endswitch
							</td>
						@empty
							<td>&nbsp;</td>
						@endforelse 
					</tr>
				@endforeach
			@else
				<tr>
					<td colspan="{{ $rowspan_empty }}" class="text-center pt-4 pb-4">Nenhum registro</td>
				</tr>
			@endif
		</tbody>
	</table>
</div>

{{ $collection->links() }}