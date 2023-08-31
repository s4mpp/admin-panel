<div class="p-4 sm:gap-4 sm:p-3 xl:p-6 xl:grid xl:grid-cols-12">
	<div class="text-sm font-medium text-slate-900 mb-3 xl:col-span-2">{{ $item->title }}</div>
	<div class="text-sm font-normal text-slate-700 xl:col-span-10">
		@switch($item->type)
			@case('boolean')
				{{ $resource->{$item->value} ? 'Sim' : 'Não' }}
			@break;
			
			@case('enum')
				<x-badge :provider="$resource->{$item->value}"></x-badge>
			@break;

			@case('markdown')
				<div class="prose max-w-none text-base">	
					{!! Str::of($resource->{$item->value})->markdown() !!}
				</div>
			@break;

			@default
				{{ $resource->{$item->value} }}
		@endswitch 
	</div>
</div>