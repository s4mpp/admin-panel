<x-element::modal.footer>
	<x-element::button type="button" x-on:click="{{ $action->getNameSlide() }} = true, {{ $action->getNameModalConfirmation() }} = false" context="{{ $action->isDangerous() ? 'danger' : 'primary' }}">Continuar</x-element::button>	
				
	<x-element::button :loading=false type="button" context="muted"
		x-on:click="{{ $action->getNameModalConfirmation() }} = false"
		className="ring-inset ring-1 ring-gray-200 btn-muted">Voltar</x-element::button>
</x-element::modal.footer>
