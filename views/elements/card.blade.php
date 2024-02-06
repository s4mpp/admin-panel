<fieldset>
	<legend>{{ $card->getTitle() }}</legend>
	
	<div class="divide-y">
		@foreach($card->getElements() as $element)
			{{ $element->render() }}
		@endforeach
	</div>
</fieldset>


{{-- <x-card title="{{ $card->getTitle() }}" :padding=false className="border bg-white">
	<div class="divide-y">
		@foreach($card->getElements() as $element)
			{{ $element->render() }}
		@endforeach
	</div>
</x-card> --}}