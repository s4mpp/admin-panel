@php
	$required = in_array('required', $field->rules);
@endphp
@switch($field->type)
	@case('select')
		<x-input :required=$required type="{{ $field->type }}" title="{{ $field->title }}" name="{{ $field->name }}" >
			@foreach($field->additional_data['options'] as $option)
				<x-option selected="{{ $resource && (($resource->{$field->name}->value ?? $resource->{$field->name}) == $option['id']) }}" value="{{ $option['id'] }}">{{ $option['label'] }}</x-option>
			@endforeach
		</x-input>
	@break;
	
	@case('permissions')
		<x-input type="checkbox" title="Permissões" name="{{ $field->name }}[]">
			@foreach($field->additional_data['permissions'] as $option)
				<x-check checked="{{ $resource && $resource->can($option['id']) }}" value="{{ $option['id'] }}">{{ $option['label'] }}</x-check>
			@endforeach
 		</x-input>
	@break;
	
	@case('boolean')
		<x-input type="checkbox" title="" name="{{ $field->name }}" >
			<x-check checked="{{ $resource->{$field->name} ?? null }}" value="1">{{ $field->title }}</x-check>
 		</x-input>
	@break;

	@case('date')
		<x-input :required=$required  type="date" title="{{ $field->title }}" name="{{ $field->name }}">
			{{ $resource->{$field->name} ? $resource->{$field->name}->format('Y-m-d') : null }}
		</x-input>
	@break;

	@default
		<x-input :required=$required rows="{{ $field->rows }}" max="{{ $field->max }}" min="{{ $field->min }}" step="{{ $field->step }}"  type="{{ $field->type }}" title="{{ $field->title }}" name="{{ $field->name }}">
			{{ $resource->{$field->name} ?? null }}
		</x-input>
@endswitch