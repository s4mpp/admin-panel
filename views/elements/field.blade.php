@php
	$required = in_array('required', $field->rules);
@endphp

<div class="p-4 sm:gap-4 sm:p-3 xl:p-6 xl:grid xl:grid-cols-12">
	<div class="text-sm font-medium text-slate-900  xl:col-span-2 xl:h-9 flex flex-col justify-center " >
		<span class="">
			{{ $field->title }}
			
			<span class="text-red-300 text-xs truncate">*</span>
		</span>

	</div>
	<div class="text-sm font-normal text-slate-700 xl:col-span-10">
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

 