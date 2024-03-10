<x-element::card title="Permissões Painel Administrativo" class="bg-white">

	<x-slot:header class="flex justify-end">
		<form method="post" class="mb-0" action="{{ route($panel->getRouteName('permissoes', 'generate')) }}" x-data="{loading: false}" x-on:submit="loading=true">
			@csrf
			@method('PUT')
			<x-element::button loading type="submit">Atualizar permissões</x-element::button>
		</form>
	</x-slot:header>

	@if(!empty($resources_with_permissions))
		<div class="divide-y  -my-4">
			@foreach($resources_with_permissions as $resource)
				<div class="py-4 ">
					<p class="font-semibold text-sm mb-2">{{ $resource['name'] }}</p>
					
					<div class="flex justify-start gap-3">
						@foreach($resource['permissions'] as $permission)
							<x-admin::roles-and-permissions.indicator title="{{ $permission->name }}" totalUsers="{{ $permission->total_users }}" />
						@endforeach
					</div>
				</div>
			@endforeach
		</div>
	@else
		<x-admin::roles-and-permissions.empty>Não há permissões geradas ainda</x-admin::roles-and-permissions.empty>
	@endif
</x-element::card>
