<div class="p-4 sm:gap-4 sm:p-3 xl:p-6 xl:grid xl:grid-cols-12">
	<div class="text-sm font-medium text-slate-900 xl:col-span-2">{{ $item->title }}</div>
	<div class="text-sm font-normal text-slate-700 xl:col-span-10">

		@if($item->getDefaultText() && is_null($resource->{$item->value}))
			<span class="opacity-60">{{ $item->getDefaultText() }}</span>
		@else
			@switch($item->getType())
				@case('boolean')
					{{ $resource->{$item->value} ? 'Sim' : 'Não' }}
				@break;
				
				@case('enum')
					<x-badge :provider="$resource->{$item->value}"></x-badge>
				@break;

				@case('datetime')
					{{ $resource->{$item->value}?->format($item->format_datetime) }}
				@break;

				@case('markdown')
					<div class="prose max-w-none text-base">	
						{!! Str::of($resource->{$item->value})->markdown() !!}
					</div>
				@break;

				@case('file')
					@break(empty($resource->{$item->value}))

					@php
						$exp = explode('.', $resource->{$item->value});
						$type_file = end($exp);
					@endphp

					@if(in_array(strtolower($type_file), ['png', 'jpg', 'jpeg', 'gif']))
						<a href="{{ Storage::url($resource->{$item->value}) }}" target="_blank"><img src="{{ Storage::url($resource->{$item->value}) }}" alt="{{ $item->title }}" class="h-12"></a>
					@else
						<a href="{{ Storage::url($resource->{$item->value}) }}" target="_blank">Visualizar {{ strtoupper($type_file) }}</a>
					@endif
				@break;

				@default
					{{ $resource->{$item->value} }}
			@endswitch 
		@endif
	</div>
</div>