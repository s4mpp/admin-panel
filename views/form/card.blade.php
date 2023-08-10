<x-card title="{{ $card->title }}">
	<div class="card-body pb-1">
		@foreach($card->elements as $element)
			{{ $element->render() }}
		@endforeach
	</div>
</x-card>