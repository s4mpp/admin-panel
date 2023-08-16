<x-card title="{{ $card->title }}">
	@foreach($card->elements as $element)
		{{ $element->render($resource) }}
	@endforeach
</x-card>