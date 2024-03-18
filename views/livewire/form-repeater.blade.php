<form wire:submit.prevent="save" x-data="{loading: false}"
	x-on:submit="loading = true"
	x-on:reset-loading.window="loading = false">

	<x-element::message.error :provider=$errors />

	<div class="space-y-4 mb-4">
		@foreach($this->form as $element)
			{{ $element->render() }}
		@endforeach
	</div>
	
	<div class="px-4 mt-4 bordert- pt-4 sm:px-0">
		<x-element::button loading type="submit" context="primary">
			<span>Concluir</span>
		</x-element::button>
	</div>
</form> 

{{-- @foreach($search_fields ?? [] as $search)
			<x-modal title="Selecionar {{ Str::lower($search->getTitle()) }}" idModal="modal{{ $search->getName() }}">
				@livewire('select-search', [
					'model' => $search->getModelName(),
					'field_to_search' => $search->getModelField(),
					'field_to_update' => $search->getName(),
					'repeater' => $search->getRepeater(),
				], key($search->getName()))
			</x-modal>
		@endforeach --}}
	{{-- </div> --}}