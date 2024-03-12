<form action="{{ $action->getUrl() }}" method="POST" class="mb-0" target="{{ $action->getTargetWindow() }}">
	@csrf
	@method($action->getMethod())

	<x-element::dropdown.button type="submit" x-on:click="dropdownCustomActions = false"><span class="py-1 block">{{ $action->getTitle() }}</span></x-element::dropdown.button>
</form>
