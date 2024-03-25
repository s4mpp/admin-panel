<div x-data="{
	modalNewPermission: false,
	modalDeletePermission: false,
	modalEditPermission: false,
	permissionEditAction: null,
	permissionDeleteAction: null,
	permissionData: {name: null}} ">

	<x-element::modal idModal="modalEditPermission" title="Editar permissão">
		<form method="post" class="mb-0" :action="permissionEditAction">
			@csrf
			@method('PUT')

			@include('admin::roles-and-permissions.form-permission')

			<x-element::modal.footer>
				<x-element::button type="submit">Salvar</x-element::button>
				<x-element::button context="muted" type="button"  x-on:click="modalEditPermission = false">Voltar</x-element::button>
			</x-element::modal.footer>
		</form>
	</x-element::modal>

	<x-element::modal danger idModal="modalDeletePermission" title="Excluir permissão" subtitle="Tem certeza que deseja excluir esta permissão?">
		<form method="post" class="mb-0" :action="permissionDeleteAction">
			@csrf
			@method('DELETE')

			<x-element::modal.footer>
				<x-element::button type="submit">Excluir</x-element::button>
				<x-element::button context="muted" type="button"  x-on:click="modalDeletePermission = false">Voltar</x-element::button>
			</x-element::modal.footer>
		</form>
	</x-element::modal>


	<x-element::modal idModal="modalNewPermission" title="Criar nova permissão">
		<form method="post" class="mb-0" action="{{ route($panel->getRouteName('permissoes', 'create-permission')) }}">
			@csrf

			@include('admin::roles-and-permissions.form-permission')

			<x-element::modal.footer>
				<x-element::button type="submit">Criar</x-element::button>
				<x-element::button context="muted" type="button"  x-on:click="modalNewPermission = false">Voltar</x-element::button>
			</x-element::modal.footer>
		</form>
	</x-element::modal>
	
	<x-element::card title="Outras permissões" class="bg-white">
		<x-slot:header class="flex justify-end">
			<x-element::button x-on:click="modalNewPermission = true">Criar nova permissão</x-element::button>
		</x-slot:header>

		@if(!$other_permissions->isEmpty())
			<div class="divide-y space-y-4">
				<div class="flex justify-start flex-wrap gap-3">
					@foreach($other_permissions as $permission)
						<x-admin::roles-and-permissions.indicator title="{{ $permission->name }}" totalUsers="{{ $permission->total_users }}">
							<x-slot:actions>
								<x-element::dropdown.button x-on:click="
									modalEditPermission=true,
									permissionData.name = '{{ $permission->name }}'
									permissionEditAction = '{{ route($panel->getRouteName('permissoes', 'update-permission'), ['id' => $permission->id]) }}',
									dropdown=false">Editar</x-element::dropdown.button>
								<x-element::dropdown.button x-on:click="
									modalDeletePermission=true,
									permissionDeleteAction = '{{ route($panel->getRouteName('permissoes', 'delete-permission'), ['id' => $permission->id]) }}',
									dropdown=false " :danger=true>Excluir</x-element::dropdown.button>
							</x-slot:actions>
						</x-admin::roles-and-permissions.indicator>
					@endforeach
				</div>
			</div>
		@else
			<x-element::empty-state message="Não há permissões cadastradas" />
		@endif
	</x-element::card>
</div>

