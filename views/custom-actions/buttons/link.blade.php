<a href="{{ $action->getUrl() }}" 
	target="{{ $action->getTargetWindow() }}"
	x-on:click="dropdownCustomActions = false"
	class="text-gray-700 hover:bg-gray-100 hover:text-gray-900 block px-4 py-2 text-sm">{{ $action->getTitle() }}</a>