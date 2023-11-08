@php
	$required = $field->isRequired();
@endphp
@switch($field->getType())
	@case('select')
		<x-input wire:model.defer="data.{{ $field->getName() }}" :required=$required type="{{ $field->getType() }}" title="" name="{{ $field->getName() }}" >
			@foreach($field->getAdditionalData('options') as $option)
				<x-option 
				{{-- selected="{{ $resource && ($value->value == $option['id']) }}" --}}
					value="{{ $option['id'] }}">{{ $option['label'] }}</x-option>
			@endforeach
		</x-input>
		@break;
	
	@case('permissions')
		<x-input title="">
			<div class="flex">
				@foreach($field->getAdditionalData('permissions') as $option)
					<x-check wire:model.defer="data.{{ $field->getName() }}" value="{{ $option['id'] }}">{{ $option['label'] }}</x-check>
				@endforeach
			</div>
		</x-input>
		@break;
	
	@case('boolean')
		<x-input title="" name="{{ $field->getName() }}" >
			<x-check wire:model.defer="data.{{ $field->getName() }}"  value="1">Habilitar</x-check>
		</x-input>
		@break;

	@case('currency')
		<x-input wire:model.defer="data.{{ $field->getName() }}" :required=$required  type="{{ $field->getType() }}" title="" name="{{ $field->getName() }}" x-mask:dynamic="$money($input, ',', '.')" placeholder="0,00">
			{{-- {{ ($value)  ? Format::currency($value, $field->getAdditionalData('has_cents')) : $default_value }} --}}
		</x-input>
		@break;

	@case('date')
		<div class="w-[150px]">
			<x-input wire:model.defer="{{ $field->getPrefix() }}.{{ $field->getName() }}" :required=$required  type="date" name="{{ $field->getName() }}" title="" >
				{{-- {{ $value ? $value->format('Y-m-d') : $default_value }} --}}
			</x-input>
		</div>
		@break;

	@default
		<x-input 
			wire:model.defer="{{ $field->getPrefix() }}.{{ $field->getName() }}"
			:required=$required
			rows="{{ $field->getAdditionalData('rows') }}"
			max="{{ $field->getAdditionalData('max') }}"
			min="{{ $field->getAdditionalData('min') }}"
			step="{{ $field->getAdditionalData('step') }}"
			type="{{ $field->getType() }}"
			name="{{ $field->getName() }}"
			title="">
				
			{{-- {{ $value ?? $default_value }} --}}
		</x-input>
@endswitch