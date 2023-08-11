<x-card title="{{ $card->title }}">
	<div class="card-body pb-1">
		@foreach($card->elements as $element)
			{{ $element->render($resource) }}
		@endforeach
	</div>
</x-card>