<x-element::card title="{{ $card->getTitle() }}" :padding=false className="bg-white">
	<div class="divide-y">
		@foreach($card->getElements() as $element)
			{{ $element->render() }}
		@endforeach
	</div>
</x-element::card>