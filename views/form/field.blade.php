@switch($field->type)
	@case('select')
		<x-input type="{{ $field->type }}" title="{{ $field->title }}" name="{{ $field->name }}" selected="{{ $resource->{$field->name} ?? null }}">
			@foreach($field->additional_data['options'] as $option)
				<x-option  value="{{ $option['id'] }}">{{ $option['label'] }}</x-option>
			@endforeach
		</x-input>
	@break;
	
	@case('boolean')
		<x-input type="checkbox" title="Title" name="{{ $field->name }}" selected="{{ $resource->{$field->name} ?? null }}">
			<x-check value="1">{{ $field->title }}</x-check>
 		</x-input>
	@break;

	@default
		<x-input rows="{{ $field->rows }}" max="{{ $field->max }}" min="{{ $field->min }}" step="{{ $field->step }}"  type="{{ $field->type }}" title="{{ $field->title }}" name="{{ $field->name }}">
			{{ $resource->{$field->name} ?? null }}
		</x-input>
@endswitch