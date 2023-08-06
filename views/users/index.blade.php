@extends('admin::layout')

@section('title', 'Usuários')

@section('title-page')

	<a href="{{ route('users_create_admin') }}" class="btn btn-success me-2 text-white"><i class="la la-plus"></i> Cadastrar novo usuário</a>

@endsection

@section('content')	 
	<div class="table-responsive">
		<table class="table   bg-white  table-sm">
			<thead>
				<tr>
					<th></th>
					<th field="name">Nome</th>
                    <th field="email">Email</th>
					<th>Ativo</th>
					<th field="created_at">Adicionado em</th>
				</tr>
			</thead>
			<tbody>
				@forelse($users as $user)
					<tr class="text-muted">
						<td class="td-btn">
							<a role="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="Editar"
								href="{{ route('users_edit_admin', ['id' => $user->id]) }}"><i class="la la-pencil"></i> 
							</a>							
						</td>
						<td class="text-dark strong">{{ $user->name }}</td>
						<td>{{ $user->email }}</td>
						<td class="text-nowrap">
							{{ $user->is_active ? 'Sim' : 'Não' }}
						</td>
						<td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
					</tr>
				@empty
					<tr>
						<td colspan="5" class="text-center pt-4 pb-4">Nenhum registro</td>
					</tr>
				@endforelse
			</tbody>
		</table>
	</div>

	{{ $users->links() }}
@endsection
