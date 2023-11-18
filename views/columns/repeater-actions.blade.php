<div class="inline-flex gap-3 font-medium text-right ">
	<a x-on:click="slide{{ $relation }} = true" wire:click.prevent="setCurrentChild('{{ $relation }}', {{ $sequence }})" class="text-gray-500 hover:text-gray-600 inline-flex gap-1 cursor-pointer">
		<span>Editar</span>
	</a>
</div>