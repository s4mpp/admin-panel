<div x-data="{modalNewRole: false, modalDeleteRole: false, modalEditRole: false, roleEditAction: null, roleDeleteAction: null, roleData: {name: null, permissions: []}}">
	<x-element::modal idModal="modalEditRole" title="Editar grupo de permissões">
		<form method="post" class="mb-0" :action="roleEditAction">
			@csrf
			@method('PUT')

			@include('admin::roles-and-permissions.form-role')

			<div class="border-t items-center gap-4 pt-4 mt-4 flex justify-between">
				<x-element::button type="button" x-on:click="modalDeleteRole = true">Excluir</x-element::button>
				
				<x-element::button type="submit">Salvar</x-element::button>
			</div>
		</form>
	</x-element::modal>

	<x-element::modal danger idModal="modalDeleteRole" title="Excluir grupo de permissões" subtitle="Tem certeza que deseja excluir este grupo de permissões?">
		<form method="post" class="mb-0" :action="roleDeleteAction">
			@csrf
			@method('DELETE')

			<div class="border-t items-center gap-4 pt-4 mt-4 flex justify-end">
				<x-element::button type="button"  x-on:click="modalDeleteRole = false">Cancelar</x-element::button>
				
				<x-element::button type="submit">Excluir</x-element::button>
			</div>
		</form>
	</x-element::modal>


	<x-element::card title="Grupos" class="bg-white">
		<x-slot:header class="flex justify-end">
			<x-element::button x-on:click="modalNewRole = true">Criar novo grupo</x-element::button>

			<x-element::modal idModal="modalNewRole" title="Criar novo grupo de permissões">
				<form method="post" class="mb-0" action="{{ route($panel->getRouteName('permissoes', 'create-role')) }}">
					@csrf

					@include('admin::roles-and-permissions.form-role')

					<div class="border-t items-center gap-4 pt-4 mt-4 flex justify-center">

						<x-element::button type="submit">Criar</x-element::button>
					</div>
				</form>
			</x-element::modal>
		</x-slot:header>

		<div class="space-y-4">
			
			<div class="flex justify-start gap-3">
				@foreach($roles as $role)
					<button class="rounded-md text-xs py-1 px-0 text-gray-900 bg-gray-200 flex items-center justify-between divide-gray-400/60 divide-x"
						x-on:click="
							modalEditRole = true,
							roleEditAction = '{{ route($panel->getRouteName('permissoes', 'update-role'), ['id' => $role->id]) }}',
							roleDeleteAction = '{{ route($panel->getRouteName('permissoes', 'delete-role'), ['id' => $role->id]) }}',
							roleData.name = '{{ $role->name }}',
							roleData.permissions = [{{ $role->permissions()->pluck('name')->map(fn($name) => '\''.$name.'\'')->join(',') }}]">
						<span class="px-2 text-xs font-semibold">{{ $role->name }}</span>
						
						<div class="flex items-center justify-normal text-gray-600 px-2">
							<x-element::icon class="h-3 w-3" mini name="users" /><span> {{ $role->users()->count() }}</span>
						</div>
					</button>
				@endforeach
			</div>
		</div>
		
	</x-element::card>
</div>