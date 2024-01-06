<div class="flex justify-start items-center">
	<span>{{ $value }}</span>

	@if($route = $item->getRoute())
		<a href="{{ route($route, ['id' => $item->getId($register)]) }}" class=" pl-4 pr-10 py-3 -mb-3 -mt-3 opacity-75 hover:opacity-100 transition-opacity">
			<x-icon class="h-5" name="arrow-top-right-on-square"></x-icon>
		</a>
	@endif
</div>

