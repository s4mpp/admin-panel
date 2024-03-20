@php
	$label = '(Não selecionado)';

	if($id = $this->data[$input->getName()])
	{	
		$model_field = app($input->getModelName())->find($id)->{$input->getModelField()};
		
		$label = $model_field ?? $id ?? NULL;
	}

	$name_with_prefix = $input->getNameWithPrefix();
@endphp

<div x-data="{
		modalSearch{{ $input->getName() }}: false,
		label_description: '{{ $label }}',
		value: @entangle($name_with_prefix).defer,
		setLabel(label) {this.label_description = label},
		setValue(value) {this.value = value},
	}"
	x-on:close-modal-search="modalSearch{{ $input->getName() }} = false"
	x-on:set-search-input="setLabel($event.detail.name); setValue($event.detail.id)">
	
	<div class="flex justify-start gap-4 items-center py-2">
		<p class="text-sm text-gray-500 whitespace-nowrap" x-text="label_description"></p>

		<button type="button" class=" rounded-lg text-gray-400 hover:text-gray-600 transition-colors" x-on:click="modalSearch{{ $input->getName() }} = true">
			<x-element::icon name="pencil-square" class="h-5"></x-element::icon>
		</button>

		<input type="hidden" x-model="value" wire:model.defer="{{ $input->getNameWithPrefix() }}" />
	</div>

	<x-element::modal title="Selecionar {{ Str::lower($input->getTitle()) }}" idModal="modalSearch{{ $input->getName() }}">

	<div x-data>
		<x-admin::input-search  
			x-on:keyup.debounce="$dispatch('search', {e: 'search:{{ $input->getName() }}', q: $event.target.value}), searching=true"
			placeholder="Pesquisar..." />

		@livewire('modal-search', [
			'field_name' => $input->getName(),
			'model' => $input->getModelName(),
			'field_to_search' => $input->getModelField(),
		], key($input->getName()))
	</div>
	</x-element::modal>
</div>