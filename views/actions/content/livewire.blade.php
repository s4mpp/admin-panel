<x-slide-over id="{{ $action->getNameSlide() }}" title="{{ $action->getTitle() }}">
	@livewire($action->getComponent(), ['register' => $action->getRegister()], key('item-action-'.$action->getSlug()))
</x-slide-over>