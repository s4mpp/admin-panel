<div class="p-4 sm:gap-4 sm:p-3 xl:p-6 xl:grid xl:grid-cols-12">
	<div class="text-sm font-medium text-slate-900 xl:col-span-2">{{ $item->getTitle() }}</div>
	<div class="text-sm font-normal text-slate-700 xl:col-span-10">

		@if($item->getDefaultText() && is_null($resource->{$item->getValue()}))
			<span class="opacity-60">{{ $item->getDefaultText() }}</span>
		@else
			@switch($item->getType())
				@case('boolean')
					{{ $resource->{$item->getValue()} ? 'Sim' : 'Não' }}
				@break;
				
				@case('enum')
					<x-badge :provider="$resource->{$item->getValue()}"></x-badge>
				@break;

				@case('datetime')
					{{ $resource->{$item->getValue()}?->format($item->getAdditionalData('format')) }}
					@if($resource->{$item->getValue()})
						<span class="opacity-50">({{ $resource->{$item->getValue()}?->diffForHumans() }})</span>
					@endif
				@break;

				@case('markdown')
					<div class="prose max-w-none text-base">	
						{!! Str::of($resource->{$item->getValue()})->markdown() !!}
					</div>
				@break;

				@case('file')
					@break(empty($resource->{$item->getValue()}))

					@php
						$exp = explode('.', $resource->{$item->getValue()});
						$type_file = end($exp);
					@endphp

					@if(in_array(strtolower($type_file), ['png', 'jpg', 'jpeg', 'gif']))
						<a href="{{ Storage::url($resource->{$item->getValue()}) }}" target="_blank"><img src="{{ Storage::url($resource->{$item->getValue()}) }}" alt="{{ $item->getTitle() }}" class="h-12"></a>
					@else
						<a href="{{ Storage::url($resource->{$item->getValue()}) }}" target="_blank">Visualizar {{ strtoupper($type_file) }}</a>
					@endif
				@break;

				@case('text')
					{{ $item->getContent() }}
				@break;

				@default
					{{ $resource->{$item->getValue()} }}
			@endswitch 
		@endif
	</div>
</div>