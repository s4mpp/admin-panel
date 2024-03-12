<div x-data="{
		modalNewRole: false,
		modalDeleteRole: false,
		modalEditRole: false,
		roleEditAction: null,
		roleDeleteAction: null,
		roleData: {name: null, permissions: []}
	}">

	<x-element::modal idModal="modalEditRole" title="Editar grupo de permissões">
		<form method="post" class="mb-0" :action="roleEditAction">
			@csrf
			@method('PUT')

			@include('admin::roles-and-permissions.form-role')

			<x-element::modal.footer>
				<x-element::button type="submit">Salvar</x-element::button>
				<x-element::button context="muted" type="button"  x-on:click="modalEditRole = false">Voltar</x-element::button>
			</x-element::modal.footer>
		</form>
	</x-element::modal>

	<x-element::modal danger idModal="modalDeleteRole" title="Excluir grupo de permissões" subtitle="Tem certeza que deseja excluir este grupo de permissões? Todas as permissoes e usuários pertencentes ao grupo serão desvinculados.">
		<form method="post" class="mb-0" :action="roleDeleteAction">
			@csrf
			@method('DELETE')

			<x-element::modal.footer>
				<x-element::button context="danger" type="submit">Excluir</x-element::button>
				<x-element::button context="muted" type="button"  x-on:click="modalDeleteRole = false">Voltar</x-element::button>
			</x-element::modal.footer>
		</form>
	</x-element::modal>


	<x-element::card title="Grupos" class="bg-white">
		<x-slot:header class="flex justify-end">
			<x-element::button x-on:click="modalNewRole = true">Criar novo grupo</x-element::button>

			<x-element::modal idModal="modalNewRole" title="Criar novo grupo de permissões">
				<form method="post" class="mb-0" action="{{ route($panel->getRouteName('permissoes', 'create-role')) }}">
					@csrf

					@include('admin::roles-and-permissions.form-role')

					<x-element::modal.footer>
						<x-element::button type="submit">Criar</x-element::button>
					</x-element::modal.footer>
				</form>
			</x-element::modal>
		</x-slot:header>

		@if(!$roles->isEmpty())
			<div class="space-y-4">
				<div class="flex justify-start gap-3">
					@foreach($roles as $role)
						<x-admin::roles-and-permissions.indicator title="{{ $role->name }}" totalUsers="{{ $role->users()->count() }}">
							<x-slot:actions>
								<x-element::dropdown.button x-on:click="
									modalEditRole=true,
									roleEditAction = '{{ route($panel->getRouteName('permissoes', 'update-role'), ['id' => $role->id]) }}',
									roleData.name = '{{ $role->name }}',
									roleData.permissions = [{{ $role->permissions()->pluck('name')->map(fn($name) => '\''.$name.'\'')->join(',') }}],
									dropdown=false">Editar</x-element::dropdown.button>
								<x-element::dropdown.button x-on:click="
									modalDeleteRole=true,
									roleDeleteAction = '{{ route($panel->getRouteName('permissoes', 'delete-role'), ['id' => $role->id]) }}',
									dropdown=false " :danger=true>Excluir</x-element::dropdown.button>
							</x-slot:actions>
						</x-admin::roles-and-permissions.indicator>
					@endforeach
				</div>
			</div>
		@else
			<x-element::empty-state message="Não há grupos cadastrados ainda"/>
		@endif
	</x-element::card>
</div>