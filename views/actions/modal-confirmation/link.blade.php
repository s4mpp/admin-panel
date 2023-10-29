<div class="flex mt-5 justify-end items-center gap-4">
	<x-button type="button" x-on:click="{{ $action->getNameModalConfirmation() }} = false" className="ring-inset ring-1 ring-gray-200 btn-muted">Voltar</x-button>
	

	<x-link target="{{ $action->getTargetWindow() }}" href="{{ $action->getUrl() }}" className="{{ $action->isDangerous() ?  'bg-red-500 hover:bg-red-600 text-white' : 'btn-primary' }}">Continuar</x-link>
</div>