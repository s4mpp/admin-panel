@php
	$required = in_array('required', $field->getRules());

	$value = $resource?->{$field->name} ?? null;

	$default_value = (!is_null($field) && is_null($value) ? $field->getDefaultText() : null);
@endphp

<div class="p-4 sm:gap-4 sm:p-3 xl:p-6 md:grid md:grid-cols-12">
	<div class="text-sm font-medium text-slate-900  md:col-span-3 lg:col-span-2 xl:h-9 flex flex-col justify-center mb-2 md:mb-0" >
		<span class="">
			{{ $field->title }}

			@if($required)
				<span class="text-red-300 text-xs truncate">*</span>
			@endif
		</span>

	</div>
	<div class="text-sm font-normal text-slate-700 md:col-span-9 lg:col-span-10 ">
		@switch($field->getType())
			@case('select')
				<x-input :required=$required type="{{ $field->getType() }}" title="" name="{{ $field->name }}" >
					@foreach($field->getAdditionalData('options') as $option)
						<x-option selected="{{ $resource && (($field->value ?? $value) == $option['id']) }}" value="{{ $option['id'] }}">{{ $option['label'] }}</x-option>
					@endforeach
				</x-input>
				@break;
			
			@case('permissions')
				<x-input title="" name="{{ $field->name }}[]">
					<div class="flex">
						@foreach($field->getAdditionalData('permissions') as $option)
							<x-check checked="{{ $resource && $resource->can($option['id']) }}" value="{{ $option['id'] }}">{{ $option['label'] }}</x-check>
						@endforeach
					</div>
				</x-input>
				@break;
			
			@case('boolean')
				<x-input title="" name="{{ $field->name }}" >
					<x-check checked="{{ $value ?? null }}" value="1">Habilitar</x-check>
				</x-input>
				@break;

			@case('currency')
				<x-input :required=$required  type="{{ $field->getType() }}" title="" name="{{ $field->name }}" x-mask:dynamic="$money($input, ',', '.')" placeholder="0,00">
					{{ ($value)  ? Format::currency($value, $field->getAdditionalData('has_cents')) : $default_value }}
				</x-input>
				@break;

			@case('date')
				<div class="w-[150px]">
					<x-input :required=$required  type="date" name="{{ $field->name }}" title="" >
						{{ $value ? $value->format('Y-m-d') : $default_value }}
					</x-input>
				</div>
				@break;

			@default
				<x-input 
					:required=$required
					rows="{{ $field->getAdditionalData('rows') }}"
					max="{{ $field->getAdditionalData('max') }}"
					min="{{ $field->getAdditionalData('min') }}"
					step="{{ $field->getAdditionalData('step') }}"
					type="{{ $field->getType() }}"
					name="{{ $field->name }}"
					title="">
						
					{{ $value ?? $default_value }}
				</x-input>
		@endswitch
	</div>
</div>