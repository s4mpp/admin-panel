<div class="space-y-4">
	<x-element::message.error :provider=$errors />
	
	<form wire:submit.prevent="save" class="space-y-4">
		<x-element::form.checkbox title="Grupos">
			<div class="border rounded-lg divide-y">
				@foreach($this->roles as $role)
					<div class="px-3 flex justify-between items-center">
						<x-element::form.checkbox.item wire:model.defer="roles_selected" value="{{ $role->id }}">{{ $role->name }}</x-element::form.checkbox.item>
						<span class="text-gray-400 text-sm">{{ $role->total_permissions }} {{ Str::of('permissão')->plural($role->total_permissions) }}</span>
					</div>
				@endforeach
			</div>
		</x-element::form.checkbox>

		<x-element::card :padding=false title="Permissões diretas" x-data="{cardDirectPermissionsOpen: false}">
		    <x-slot:header class="flex justify-end">
				<x-element::button type="button" size="sm" context="muted" x-on:click="cardDirectPermissionsOpen = !cardDirectPermissionsOpen">
					<x-element::icon class="h-4 w-4" mini name="chevron-down" x-show="!cardDirectPermissionsOpen" />
					<x-element::icon class="h-4 w-4" mini name="chevron-up" x-show="cardDirectPermissionsOpen" />
				</x-element::button>
			</x-slot:header>

			<div x-show="cardDirectPermissionsOpen" class="divide-y px-4 py-5 sm:px-6">
				@foreach($this->resources_with_permissions as $resource)
					<x-element::form.checkbox title="{{ $resource['name'] }}">
						@foreach($resource['permissions'] as $permission)
							<x-element::form.checkbox.item  wire:model.defer="permissions_selected"  value="{{ $permission['id'] }}">{{ $permission['name'] }}</x-element::form.checkbox.item>
						@endforeach
					</x-element::form.checkbox>
				@endforeach
			</div>
		</x-element::card>

		<x-element::button type="submit">Salvar</x-element::button>
	</form>
</div>