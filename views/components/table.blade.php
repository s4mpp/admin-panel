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
				
				@forelse($columns as $field)
					<th @class(array_merge($field->style_class, ['text-nowrap']))>{{ $field->title }}</th>
				@empty
					<th>&nbsp;</th>
				@endforelse
			</tr>
		</thead>
		<tbody>
			@if($data_table)
				@foreach($data_table as $id => $row)
					<tr class="text-muted">
						@if($actions)
							<td class=" d-flex justify-content-start gap-3">
								@foreach($actions as $action)
									@if($action->has_confirmation)
										<form  class="float-none d-inline" method="POST" onsubmit="return window.confirm('Tem certeza?')" action="{{ route($actionRoutes['delete'], ['id' => $id]) }}">
											@method('DELETE')
											@csrf
											<button type="submit" class="btn text-{{ $action->context }} p-0"><i class="la la-{{ $action->icon }}"></i> {{ $action->label }}</a></button>
										</form>
									@else
										<a class="text-{{ $action->context }}" href="{{ route($actionRoutes[$action->route], ['id' => $id]) }}"><i class="la la-{{ $action->icon }}"></i> {{ $action->label }}</a>
									@endif
								@endforeach
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

{{ $provider->links() }}