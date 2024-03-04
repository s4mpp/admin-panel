<x-element::card title="Permissões Painel Administrativo" class="bg-white">

	<x-slot:header class="flex justify-end">
		<form method="post" class="mb-0" action="{{ route($panel->getRouteName('permissoes', 'generate')) }}" x-data="{loading: false}" x-on:submit="loading=true">
			@csrf
			@method('PUT')
			<x-element::button loading type="submit">Atualizar permissões</x-element::button>
		</form>
	</x-slot:header>

	<div class="divide-y space-y-4">
		@foreach($resources_with_permissions as $resource)
			<div class="">
				<p class="font-semibold text-sm mb-2">{{ $resource['name'] }}</p>
				
				<div class="flex justify-start gap-3">
					@foreach($resource['permissions'] as $permission)
						<div class="rounded-md py-1 px-2 text-gray-900 bg-gray-200" >
							<span class="text-xs">{{ $permission->name }}</span>

							<div class="flex items-center justify-normal text-gray-600 px-2">
								<x-element::icon class="h-3 w-3" mini name="users" /><span> {{ $permission->total_users }}</span>
							</div>
						</div>
					@endforeach
				</div>
			</div>
		@endforeach
	</div>
</x-element::card>
