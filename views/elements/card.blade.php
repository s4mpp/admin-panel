<x-card title="{{ $card->getTitle() }}" :padding=false className="border bg-white">
	<div class="divide-y">
		@foreach($card->getElements() as $element)
			{{ $element->render($resource) }}
		@endforeach
	</div>
</x-card>