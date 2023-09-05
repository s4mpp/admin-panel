<x-card title="{{ $card->title }}" :padding=false>
	<div class="divide-y">
		@foreach($card->elements as $element)
			{{ $element->render($resource) }}
		@endforeach
	</div>
</x-card>