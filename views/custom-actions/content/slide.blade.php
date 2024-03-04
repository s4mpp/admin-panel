<x-element::slide-over idSlide="{{ $action->getNameSlide() }}" title="{{ $action->getTitle() }}">
	@include($action->getView())
</x-element::slide-over>