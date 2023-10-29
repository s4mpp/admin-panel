<button 
	x-on:click="dropdownCustomActions = false, {{ $action->getNameSlide() }} = true"
	class="text-gray-700 hover:bg-gray-100 hover:text-gray-900 block px-4 py-2 text-sm w-full text-start">{{ $action->getTitle() }}</button>