<div class="mb-6">
	<x-card title="{{ $card->title }}">
		<div class="divide-y">
			@foreach($card->elements as $element)
				{{ $element->render($resource) }}
			@endforeach
		</div>
	</x-card>
</div>