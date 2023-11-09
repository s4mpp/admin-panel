<div class="flex mt-5 justify-end items-center gap-4" x-data="{loading: false}">
	<x-button :loading=false type="button" 
		x-on:click="{{ $action->getNameModalConfirmation() }} = false" 
		className="ring-inset ring-1 ring-gray-200 btn-muted">Voltar</x-button>
	
	<x-link target="{{ $action->getTargetWindow() }}" 
		x-on:click="{{ !$action->isNewTab() ? 'loading = true' : null }}"
		href="{{ $action->getUrl() }}" 
		className="{{ $action->isDangerous() ? 'bg-red-500 hover:bg-red-600 text-white' : 'btn-primary' }}">
		Continuar
	</x-link>
</div>