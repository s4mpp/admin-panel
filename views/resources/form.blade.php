<x-card title="">
	<div class="card-body pb-0">
		<div class="row">
			@foreach($form->fields ?? [] as $field)
				
				<div class="col-12">
					@switch($field->type)
						@case('select')
							<x-input type="{{ $field->type }}" title="{{ $field->title }}" name="{{ $field->name }}" selected="{{ $form->resource->{$field->name} ?? null }}">
								@foreach($field->additional_data['options'] as $option)
									<x-option  value="{{ $option['id'] }}">{{ $option['label'] }}</x-option>
								@endforeach
							</x-input>
						@break;
						
						@case('boolean')
							<x-check type="checkbox" name="{{ $field->name }}" value="1" isChecked="{{ ($form->resource ?? false) && $form->resource->{$field->name} }}">{{ $field->title }}</x-check>
						@break;

						@default
							<x-input max="{{ $field->max }}" min="{{ $field->min }}" step="{{ $field->step }}"  type="{{ $field->type }}" title="{{ $field->title }}" name="{{ $field->name }}">
								{{ $form->resource->{$field->name} ?? null }}
							</x-input>
					@endswitch
				</div>
			@endforeach
		</div>
	</div>
</x-card>

