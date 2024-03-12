<x-element::dropdown.button
	x-on:click="dropdown = false, {{ $action->getNameSlide() }} = true"
	x-on:close-slide.window="{{ $action->getNameSlide() }} = false"><span class="py-1 block">{{ $action->getTitle() }}</span></x-element::dropdown.button>