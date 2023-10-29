<x-modal title="{{ $action->getTitle() }}" idModal="{{ $action->getNameModal() }}">

	<form action="{{ $action->getUrl() }}" method="POST" x-data="{loading: false}" x-on:submit="loading = true" target="{{ $action->getTargetWindow() }}" >
		@csrf
		@method('PUT')
		<x-input type="text" required title="{{ $action->getMessage() }}" name="answer" />
			
		<div class="flex mt-5 justify-end items-center gap-4">
			<x-button type="button" x-on:click="{{ $action->getNameModal() }} = false" className="ring-inset ring-1 ring-gray-200 btn-muted">Voltar</x-button>
			
			<x-button className=" btn-primary">Continuar</x-button>
		</div>
	</form>

</x-modal>