@php
	$required = in_array('required', $field->rules);
@endphp
<div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 py-6 px-3">
	<label for="{{ $field->name }}" class="block text-sm font-medium leading-6 text-slate-900 sm:pt-1.5">{{ $field->title }}</label>
	<div class="mt-2 sm:col-span-2 sm:mt-0 {{ join(' ', $field->class) }}">
		@switch($field->type)
			@case('select')
				<x-input :required=$required type="{{ $field->type }}" title="" name="{{ $field->name }}" >
					@foreach($field->additional_data['options'] as $option)
						<x-option selected="{{ $resource && (($resource->{$field->name}->value ?? $resource->{$field->name}) == $option['id']) }}" value="{{ $option['id'] }}">{{ $option['label'] }}</x-option>
					@endforeach
				</x-input>
			@break;
			
			@case('permissions')
				<x-input type="checkbox" title="" name="{{ $field->name }}[]">
					@foreach($field->additional_data['permissions'] as $option)
						<x-check checked="{{ $resource && $resource->can($option['id']) }}" value="{{ $option['id'] }}">{{ $option['label'] }}</x-check>
					@endforeach
				</x-input>
			@break;
			
			@case('boolean')
				<x-input type="checkbox" title="" name="{{ $field->name }}" >
					<x-check checked="{{ $resource->{$field->name} ?? null }}" value="1">Habilitar</x-check>
				</x-input>
			@break;

			@default
				<x-input :required=$required rows="{{ $field->rows }}" max="{{ $field->max }}" min="{{ $field->min }}" step="{{ $field->step }}"  type="{{ $field->type }}" title="" name="{{ $field->name }}">
					{{ $resource->{$field->name} ?? null }}
				</x-input>
		@endswitch

	</div>
</div>

 