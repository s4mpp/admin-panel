<div class="space-y-4">
	<x-element::form.input x-model="roleData.name" type="text" title="Nome do grupo" name="role_name"></x-element::form.input>

	@foreach($resources_with_permissions as $resource)
		<x-element::form.checkbox title="{{ $resource['name'] }}">
			@foreach($resource['permissions'] as $permission)
				<x-element::form.checkbox.item x-model="roleData.permissions" name="permissions[]" value="{{ $permission->name }}">{{ $permission->name }}</x-element::form.checkbox.item>
			@endforeach
		</x-element::form.checkbox>
	@endforeach
</div>