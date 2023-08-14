@switch($item->type)
	@case('boolean')
		<x-item-view title="{{ $item->title }}">{{ $resource->{$item->value} ? 'Sim' : 'Não' }}</x-item-view>
	@break;
	
	@case('enum')
		<x-item-view title="{{ $item->title }}">{{ $resource->{$item->value}->label() }}</x-item-view>
	@break;

	@default
		<x-item-view title="{{ $item->title }}">{{ $resource->{$item->value} }}</x-item-view>
@endswitch