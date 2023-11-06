<x-card title="{{ $card->getTitle() }}" :padding=false>
	<div class="divide-y">
		@foreach($card->getElements() as $element)
			{{ $element->render($resource) }}
		@endforeach
	</div>
</x-card>