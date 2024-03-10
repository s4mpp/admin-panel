<x-element::modal.footer>
	<x-element::link 
		href="{{ $action->getUrl() }}" 
		x-on:click="{{ !$action->isNewTab() ? 'loading = true' : null }}"
		loading
		type="submit" context="{{ $action->isDangerous() ? 'danger' : 'primary' }}">Continuar</x-element::link>	
				
	<x-element::button :loading=false type="button" context="muted"
		x-on:click="{{ $action->getNameModalConfirmation() }} = false"
		className="ring-inset ring-1 ring-gray-200 btn-muted">Voltar</x-element::button>
</x-element::modal.footer>