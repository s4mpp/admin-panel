<x-element::dropdown.link href="{{ $action->getUrl() }}" 
	target="{{ $action->getTargetWindow() }}"
	x-on:click="dropdownCustomActions = false"><span class="py-1 block">{{ $action->getTitle() }}</span></x-element::dropdown.link>