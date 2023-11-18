@extends('admin::crud.resource')

@section('title', 'Cadastrar')

@section('content-resource')

	@livewire('form-resource', [
		'resource_name' => $resource->getName()
	])
@endsection
