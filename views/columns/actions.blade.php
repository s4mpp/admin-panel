<div class="inline-flex gap-3 font-medium text-right ">
	@if(array_key_exists('read', $actions))
		<a	href="{{ route($actions['read'], ['id' => $value]) }}" class="text-gray-500 hover:text-gray-600 inline-flex gap-1">
			<span>Visualizar</span>
		</a>
	@endif
	
	@if(array_key_exists('update', $actions))
		<a	href="{{ route($actions['update'], ['id' => $value]) }}" class="text-gray-500 hover:text-gray-600 inline-flex gap-1">
			<span>Editar</span>
		</a>
	@endif

	@if(array_key_exists('delete', $actions))
		<form onsubmit="return window.confirm('Tem certeza que deseja excluir este registro?')" method="POST"  action="{{ route($actions['delete'], ['id' => $value]) }}">
			@method('DELETE')
			@csrf
			
			 <button class="text-red-500 hover:text-red-600 inline-flex gap-1" type="submit">Excluir</button>
		</form>
	@endif
</div>