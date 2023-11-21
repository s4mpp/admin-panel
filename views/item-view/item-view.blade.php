<div class="p-4 sm:gap-4 sm:p-3 xl:p-6 xl:grid xl:grid-cols-12">
	<div class="text-sm font-medium text-slate-900 xl:col-span-2">{{ $item->getTitle() }}</div>
	<div class="text-sm font-normal text-slate-700 xl:col-span-10">

		@if($item->getDefaultText() && is_null($item->getValue($register)))
			<span class="opacity-60">{{ $item->getDefaultText() }}</span>
		@elseif(method_exists($item, 'renderView'))
			{{ $item->renderView($item->getValue($register), $register) }}
		@else
			{{ $item->getValue($register) }}
		@endif
	</div>
</div>