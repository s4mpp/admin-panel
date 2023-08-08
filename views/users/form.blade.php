@csrf

<x-card title="">
	<div class="card-body pb-0">
		<div class="row">
			<div class="  col-md-6 col-lg-4">
				<x-input type="text" required input-group-start="<i class='la la-user'></i>" title="Nome" name="name" >{{ $user->name ?? null }}</x-input>
			</div>
			<div class="  col-md-6 col-lg-4">
				<x-input type="email" required input-group-start="<i class='la la-envelope'></i>"  title="E-mail" name="email" >{{ $user->email ?? null }}</x-input>
			</div>
			<div class="col-md-12 col-lg-4">
				<x-check type="checkbox" name="is_active" value="1" isChecked="{{ ($user ?? false) && $user->is_active }}">Ativo</x-check>
			</div>
		</div>
	</div>
</x-card>