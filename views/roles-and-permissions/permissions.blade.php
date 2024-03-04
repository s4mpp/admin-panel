<div x-data="{modalNewPermission: false, modalDeleteRole: false, modalEditPermission: false, permissionEditAction: null, permissionDeleteAction: null, permissionData: {name: null}}">
	<x-element::card title="Outras permissões" class="bg-white">
		<x-slot:header class="  flex justify-end">
			<x-element::modal idModal="modalEditPermission" title="Editar permissão">
				<form method="post" class="mb-0" :action="permissionEditAction">
					@csrf
					@method('PUT')

					@include('admin::roles-and-permissions.form-permission')

					<div class="border-t items-center gap-4 pt-4 mt-4 flex justify-between">
						<x-element::button type="button" x-on:click="modalDeleteRole = true">Excluir</x-element::button>
						
						<x-element::button type="submit">Salvar</x-element::button>
					</div>
				</form>
			</x-element::modal>

			<x-element::modal danger idModal="modalDeleteRole" title="Excluir permissão" subtitle="Tem certeza que deseja excluir esta permissão?">
				<form method="post" class="mb-0" :action="permissionDeleteAction">
					@csrf
					@method('DELETE')

					<div class="border-t items-center gap-4 pt-4 mt-4 flex justify-end">
						<x-element::button type="button"  x-on:click="modalDeleteRole = false">Cancelar</x-element::button>
						
						<x-element::button type="submit">Excluir</x-element::button>
					</div>
				</form>
			</x-element::modal>

			<x-element::button x-on:click="modalNewPermission = true">Criar nova permissão</x-element::button>

			<x-element::modal idModal="modalNewPermission" title="Criar nova permissão">
				<form method="post" class="mb-0" action="{{ route($panel->getRouteName('permissoes', 'create-permission')) }}">
					@csrf

					@include('admin::roles-and-permissions.form-permission')

					<div class="border-t items-center gap-4 pt-4 mt-4 flex justify-center">

						<x-element::button type="submit">Criar</x-element::button>
					</div>
				</form>
			</x-element::modal>
		</x-slot:header>

		<div class="divide-y space-y-4">
			<div class="">				
				<div class="flex justify-start gap-3">
					@foreach($other_permissions as $permission)
						<button class="rounded-md py-1 px-2 text-gray-900 bg-gray-200"
							x-on:click="
								modalEditPermission = true,
								permissionEditAction = '{{ route($panel->getRouteName('permissoes', 'update-permission'), ['id' => $permission->id]) }}',
								permissionDeleteAction = '{{ route($panel->getRouteName('permissoes', 'delete-permission'), ['id' => $permission->id]) }}',
								permissionData.name = '{{ $permission->name }}'">
							<span class="text-xs">{{ $permission->name }}</span>
						</button>
					@endforeach
				</div>
			</div>
		</div>
	</x-element::card>
</div>

