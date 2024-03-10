
	<form action="{{ $action->getUrl() }}" x-data="{loading: false}"
		method="POST" 
		x-on:submit="{{ !$action->isNewTab() ? 'loading = true' : null }}"
		target="{{ $action->getTargetWindow() }}">
		@csrf
		@method($action->getMethod())
		
		<x-element::modal.footer>
			<x-element::button loading type="submit" context="{{ $action->isDangerous() ? 'danger' : 'primary' }}">Continuar</x-element::button>	
			
			<x-element::button :loading=false type="button" context="muted"
				x-on:click="{{ $action->getNameModalConfirmation() }} = false"
				className="ring-inset ring-1 ring-gray-200 btn-muted">Voltar</x-element::button>
		</x-element::modal.footer>
	</form>
