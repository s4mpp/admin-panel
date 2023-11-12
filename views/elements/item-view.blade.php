<div class="p-4 sm:gap-4 sm:p-3 xl:p-6 xl:grid xl:grid-cols-12">
	<div class="text-sm font-medium text-slate-900 xl:col-span-2">{{ $item->getTitle() }}</div>
	<div class="text-sm font-normal text-slate-700 xl:col-span-10">

		@if($item->getDefaultText() && is_null($register->{$item->getValue()}))
			<span class="opacity-60">{{ $item->getDefaultText() }}</span>
		@else
			@switch($item->getType())
				@case('boolean')
					{{ $register->{$item->getValue()} ? 'Sim' : 'Não' }}
				@break;
				
				@case('enum')
					<x-badge :provider="$register->{$item->getValue()}"></x-badge>
				@break;

				@case('datetime')
					{{ $register->{$item->getValue()}?->format($item->getAdditionalData('format')) }}
					@if($register->{$item->getValue()})
						<span class="opacity-50">({{ $register->{$item->getValue()}?->diffForHumans() }})</span>
					@endif
				@break;

				@case('markdown')
					<div class="prose max-w-none text-base">	
						{!! Str::of($register->{$item->getValue()})->markdown() !!}
					</div>
				@break;

				@case('file')
					@break(empty($register->{$item->getValue()}))

					@php
						$exp = explode('.', $register->{$item->getValue()});
						$type_file = end($exp);
					@endphp

					@if(in_array(strtolower($type_file), ['png', 'jpg', 'jpeg', 'gif']))
						<a href="{{ Storage::url($register->{$item->getValue()}) }}" target="_blank"><img src="{{ Storage::url($register->{$item->getValue()}) }}" alt="{{ $item->getTitle() }}" class="h-12"></a>
					@else
						<a href="{{ Storage::url($register->{$item->getValue()}) }}" target="_blank">Visualizar {{ strtoupper($type_file) }}</a>
					@endif
				@break;

				@case('longtext')
					{{ $item->getContent() }}
				@break;

				@default
					{{ $register->{$item->getValue()} }}
			@endswitch 
		@endif
	</div>
</div>