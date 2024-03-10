<form action="{{ $action->getUrl() }}" method="POST" class="mb-0" target="{{ $action->getTargetWindow() }}">
	@csrf
	@method($action->getMethod())

	<x-admin::dropdown.button type="submit" x-on:click="dropdownCustomActions = false"><span class="py-1 block">{{ $action->getTitle() }}</span></x-admin::dropdown.button>
</form>
