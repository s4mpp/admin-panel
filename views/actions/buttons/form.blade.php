<form action="{{ $action->getUrl() }}" method="POST" target="{{ $action->getTargetWindow() }}">
	@csrf
	@method($method)
	
	<button type="submit" 
		x-on:click="dropdownCustomActions = false"
		class="text-gray-700 hover:bg-gray-100 hover:text-gray-900 block px-4 py-2 text-sm w-full text-start">{{ $action->getTitle() }}</button>
</form>
