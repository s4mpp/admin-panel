<button disabled 
	data-tippy-content="{{ $action->getDisabledMessage() }}"
	class="text-gray-700/50 cursor-not-allowed  block px-4 py-2 text-sm w-full text-start">{{ $action->getTitle() }}</button>