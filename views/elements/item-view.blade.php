{{-- @switch($item->type)
	@case('boolean')
		<x-item-view title="{{ $item->title }}">{{ $resource->{$item->value} ? 'Sim' : 'Não' }}</x-item-view>
	@break;
	
	@case('enum')
		<x-item-view title="{{ $item->title }}">{{ $resource->{$item->value}->label() }}</x-item-view>
	@break;

	@default
		<x-item-view title="{{ $item->title }}">{{ $resource->{$item->value} }}</x-item-view>
@endswitch --}}


<div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
	<dt class="text-sm font-medium text-slate-900">{{ $item->title }}</dt>
	<dd class="mt-1 text-sm leading-6 text-slate-700 sm:col-span-2 sm:mt-0">
		@switch($item->type)
			@case('boolean')
				{{ $resource->{$item->value} ? 'Sim' : 'Não' }}
			@break;
			
			@case('enum')
				{{ $resource->{$item->value}->label() }}
			@break;

			@default
				{{ $resource->{$item->value} }}
		@endswitch 
	</dd>
</div>